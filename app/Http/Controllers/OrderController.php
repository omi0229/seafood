<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Traits\General;
use App\Models\Config;
use App\Models\Orders;
use App\Models\DiscountRecord;
use App\Repositories\OrderRepository;
use App\Services\UserServices;
use App\Services\OrderServices;
use App\Services\DiscountCodeServices;
use App\Services\CouponServices;
use App\Mail\PaymentSuccess;

class OrderController extends Controller
{
    use General;

    protected $service_name = 'orders';

    protected $request, $model, $repository, $services;

    public function __construct(Request $request, Orders $model, OrderRepository $repository, OrderServices $services)
    {
        $this->request = $request;
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function update()
    {
        if (!data_get($this->request->all(), 'id')) {
            return response()->json(['status' => false, 'message' => '編輯失敗']);
        }

        $id = data_get($this->request->all(), 'id');

        $model = $this->repository->find($this->model::decodeSlug($id), ['delivery_method']);

        $data = $this->request->only('receiver', 'shipment_at', 'admin_bookmark', 'order_status');

        $inputs = [
            'name' => $data['receiver']['name'],
            'cellphone' => $data['receiver']['cellphone'],
            'email' => $data['receiver']['email'],
            'zipcode' => $data['receiver']['zipcode'],
            'country' => $data['receiver']['country'],
            'city' => $data['receiver']['city'],
            'address' => $data['receiver']['address'],
            'shipment_at' => $data['shipment_at'],
            'admin_bookmark' => $data['admin_bookmark'],
            'order_status' => $data['order_status'],
        ];

        # 驗證資料
        $validator = $this->services::authInputData($inputs, $model->delivery_method);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $this->repository->update($this->model::decodeSlug($id), $inputs);

        return response()->json(['status' => true, 'message' => '編輯成功']);
    }

    public function export($type) {
        return $this->services->exportOrders($type, $this->request->all());
    }

    # ATM繳費回傳結果
    public function ecpayReturn(UserServices $userServices)
    {
        $model = Config::Where('config_name', 'goldflow_HashKey')->orWhere('config_name', 'goldflow_HashIV')->get();
        $HashKey = $model->find('goldflow_HashKey') ? $model->find('goldflow_HashKey')->config_value : null;
        $HashIV = $model->find('goldflow_HashIV') ? $model->find('goldflow_HashIV')->config_value : null;
        if ($HashKey && $HashIV) {
            $inputs = $this->request->all();
            $CheckMacValueService = new \Ecpay\Sdk\Services\CheckMacValueService($HashKey, $HashIV, 'sha256');
            # 用ATM付款
            if ($CheckMacValueService->verify($inputs) && data_get($inputs, 'PaymentType') && $inputs['PaymentType'] !== 'Credit_CreditCard') {
                $order_id = Orders::decodeSlug($inputs['CustomField1']);
                $order = $this->repository->find($order_id);
                if ((int)$inputs['RtnCode'] === 1) {
                    $this->repository->update($order_id, ['payment_status' => 1]);

                    # 如果有用優惠劵並且付款成功
                    if (data_get($inputs, 'CustomField2')) {
                        $coupon_record_id = $inputs['CustomField2'];
                        $record = DiscountRecord::find(DiscountRecord::decodeSlug($coupon_record_id));
                        if ($record) {
                            $record->member_id = $order->member_id;
                            $record->used_at = now();
                            $record->save();
                        }
                    }

                    $order->refresh();

                    # line notify 推播
                    $userServices->pushAdminNotify('訂單編號：' . $order->merchant_trade_no . ' 訂單成立(已成功付款)');

                    # mail 通知
                    $this->__sendMail($order);
                } else {
                    # 20220427新增 訂單狀況為已付款則不得再度更改付款狀態
                    if ($order->payment_status !== 1) {
                        $this->repository->update($order_id, ['payment_status' => -2]);

                        $order->refresh();

                        # mail 通知
                        $this->__sendMail($order);
                    }
                }

                \AppLog::record([
                    'type' => 'payment',
                    'user_id' => $order->member_id,
                    'data_id' => $order_id,
                    'content' => json_encode($inputs),
                ]);
            }
        }

        return "1|OK";
    }

    # 信用卡繳費回傳結果
    public function ecpayResult(UserServices $userServices)
    {
        $model = Config::Where('config_name', 'goldflow_HashKey')->orWhere('config_name', 'goldflow_HashIV')->get();
        $HashKey = $model->find('goldflow_HashKey') ? $model->find('goldflow_HashKey')->config_value : null;
        $HashIV = $model->find('goldflow_HashIV') ? $model->find('goldflow_HashIV')->config_value : null;
        if ($HashKey && $HashIV) {
            $inputs = $this->request->all();
            $CheckMacValueService = new \Ecpay\Sdk\Services\CheckMacValueService($HashKey, $HashIV, 'sha256');
            if ($CheckMacValueService->verify($inputs) && data_get($inputs, 'CustomField1') && data_get($inputs, 'RtnCode')) {
                $RtnCode = (int)$inputs['RtnCode'];

                $order_id = Orders::decodeSlug($inputs['CustomField1']);
                $order = $this->repository->find($order_id);

                # 20220427新增 訂單狀況為已付款則不得再度更改付款狀態
                if ($order->payment_status !== 1) {
                    $payment_status = $RtnCode === 1 ? 1 : -2;
                } else {
                    $payment_status = 1;
                }

                $this->repository->update($order_id, [
                    'payment_method' => 1,
                    'payment_status' => $payment_status,
                    'TradeNo' => null,
                    'BankCode' => null,
                    'vAccount' => null,
                    'ExpireDate' => null,
                ]);

                $order->refresh();

                # 如果有用優惠劵並且付款成功
                if (data_get($inputs, 'CustomField2')) {
                    $coupon_record_id = $inputs['CustomField2'];
                    $record = DiscountRecord::find(DiscountRecord::decodeSlug($coupon_record_id));
                    if ($record) {
                        $record->orders_id = $order_id;
                        $record->member_id = $order->member_id;
                        $record->used_at = now();
                        $record->save();
                    }
                }

                $payment_status_message = $RtnCode === 1 ? '訂單成立(已成功付款)' : '付款失敗';
                # line notify 推播
                $userServices->pushAdminNotify('訂單編號：' . $order->merchant_trade_no . ' ' . $payment_status_message);

                # mail 通知
                $this->__sendMail($order);

                # 付款紀錄
                \AppLog::record([
                    'type' => 'payment',
                    'user_id' => $order->member_id,
                    'data_id' => $order_id,
                    'content' => json_encode($inputs),
                ]);
            } else {
                # 其他紀錄
                \AppLog::record([
                    'type' => 'payment_error',
                    'user_id' => null,
                    'data_id' => null,
                    'content' => json_encode($inputs),
                ]);
            }
        }

        header("Location: " . env('FRONT_PAGE_URL') . 'account/record');
        exit;
    }

    public function ecpayRedirect()
    {
        $inputs = $this->request->all();
        if (data_get($inputs, 'CustomField1')) {
            $order_id = Orders::decodeSlug($inputs['CustomField1']);
            $order = $this->repository->find($order_id);
            $this->repository->update($order_id, [
                'payment_method' => 2,
                'TradeNo' => $inputs['TradeNo'],
                'BankCode' => $inputs['BankCode'],
                'vAccount' => $inputs['vAccount'],
                'ExpireDate' => $inputs['ExpireDate'],
            ]);

            # 如果有用優惠劵
            if (data_get($inputs, 'CustomField2')) {
                $coupon_record_id = $inputs['CustomField2'];
                $record = DiscountRecord::find(DiscountRecord::decodeSlug($coupon_record_id));
                if($record) {
                    $record->orders_id = $order_id;
                    $record->save();
                }
            }

            \AppLog::record([
                'type' => 'payment_get_vAccount',
                'user_id' => $order->member_id,
                'data_id' => $order_id,
                'content' => json_encode([
                    'TradeNo' => $inputs['TradeNo'],
                    'BankCode' => $inputs['BankCode'],
                    'vAccount' => $inputs['vAccount'],
                    'ExpireDate' => $inputs['ExpireDate'],
                ]),
            ]);
        }

        header("Location: " . env('FRONT_PAGE_URL') . 'account/order/' . $inputs['CustomField1']);
        exit;
    }

    public function ecpayServerReply()
    {
        $inputs = $this->request->all();

        if (data_get($inputs, 'AllPayLogisticsID') && data_get($inputs, 'BookingNote')) {

            $order = $this->model->where('AllPayLogisticsID', $inputs['AllPayLogisticsID'])
                ->where('BookingNote', $inputs['BookingNote'])
                ->get()
                ->first();

            if ($order) {
                $order->RtnCode = $inputs['RtnCode'];
                $order->RtnMsg = $inputs['RtnMsg'];
                $order->save();

                \AppLog::record([
                    'type' => 'logistics',
                    'data_id' => $order->id,
                    'content' => json_encode($inputs),
                ]);

                return '1|OK';
            }
        }
    }

    public function logisticsForm()
    {
        return response()->Json(OrderServices::ecpayLogisticsForm($this->request->all()));
    }

    public function logisticsPrintUrl()
    {
        return response()->json(['status' => true, 'message' => '取得列印貨運單網址成功', 'data' => env('ECPAY.PRINT_URL')]);
    }

    public function logisticsPrint()
    {
        return response()->json(['status' => true, 'message' => 'form data 建立成功', 'ecpay' => OrderServices::ecpayLogisticsPrint($this->request->all())]);
    }

    # Line pay繳費回傳結果
    public function linepayResult()
    {
        $transactionId = data_get($this->request->all(), 'transactionId');
        $orderId = data_get($this->request->all(), 'orderId');
        $order = $this->model::with(['order_products', 'discount_record', 'discount_record.discount_codes', 'discount_record.coupon'])->firstWhere('merchant_trade_no', $orderId);

        if ($transactionId && $orderId && $order) {

            $model = Config::where('config_name', 'line_channel_id')->orWhere('config_name', 'line_secret_key')->get();
            $channelId = $model->find('line_channel_id') ? $model->find('line_channel_id')->config_value : null;
            $channelSecret = $model->find('line_secret_key') ? $model->find('line_secret_key')->config_value : null;

            if ($channelId && $channelSecret) {
                # 如果有優惠代碼
                $discount = null;
                $discount_record = $order->discount_record->where('type', 'discount_codes')->first();
                if ($discount_record) {
                    $discount = DiscountCodeServices::setDiscountCode($order->id, 'make_up', ['discount_codes' => $discount_record->discount_codes->fixed_name], $order->order_products, $order->freight);
                }

                # 如果有優惠劵
                $coupon_discount = null;
                $coupon_record = $order->discount_record->where('type', 'coupon')->first();
                if ($coupon_record) {
                    $coupon_discount = CouponServices::setCoupon(['coupon_record_id' => $coupon_record->hash_id]);
                }

                $content = [
                    'amount' => OrderServices::listTotalAmount($order->order_products, $order->freight, 'make_up', 'all_total', $discount, $coupon_discount),
                    'currency' => 'TWD',
                ];

                $uri = '/v3/payments/' . $transactionId . '/confirm';
                $response = json_decode($this->services->linePayApi($channelId, $channelSecret, $uri, $content), true);

                # 付款成功 更改相關狀態
                if($response['returnCode'] === '0000' && $response['returnMessage'] === 'Success.') {

                    # 補上優惠代碼使用會員 and 使用時間
                    if ($discount_record) {
                        $discount_record->member_id = $order->member_id;
                        $discount_record->used_at = now();
                        $discount_record->save();
                    }

                    # 補上優惠劵使用的訂單 and 使用時間
                    if ($coupon_record) {
                        $coupon_record->orders_id = $order->id;
                        $coupon_record->used_at = now();
                        $coupon_record->save();
                    }

                    # 修改訂單付款狀態
                    $order->payment_status = 1;
                    $order->save();

                    # line notify 推播
                    $userServices = new UserServices;
                    $userServices->pushAdminNotify('訂單編號：' . $order->merchant_trade_no . ' 訂單成立(已成功付款)');

                    # mail 通知
                    $this->__sendMail($order);

                } else {

                    # 20220427新增 訂單狀況為已付款則不得再度更改付款狀態
                    if ($order->payment_status !== 1) {
                        ### line 付款失敗 執行以下
                        # 金額錯誤 (scale)
                        if ($response['returnCode'] === '1124') {
                            $order->payment_status = -1;
                            $order->save();
                        } else {
                            # 其他付款失敗
                            $order->payment_status = -2;
                            $order->save();
                        }

                        # 歸還優惠代碼
                        if ($discount_record) {
                            $discount_record->delete();
                        }

                        # 歸還優惠劵
                        if ($coupon_record) {
                            $coupon_record->orders_id = null;
                            $coupon_record->save();
                        }

                        # mail 通知
                        $this->__sendMail($order);
                    }

                }

                \AppLog::record([
                    'type' => 'payment',
                    'user_id' => $order->member_id,
                    'data_id' => $order->id,
                    'content' => json_encode($response),
                ]);

                header("Location: " . env('FRONT_PAGE_URL') . 'account/order/' . $order->hash_id);
                exit;
            }
        }

        return response()->json(['error' => 'Not authorized.'], 403);
    }

    # mail 通知
    private function __sendMail($order)
    {
        # mail 通知
        try {
            Mail::to($order->email)->send(new PaymentSuccess($order));
        } catch (\Exception $e) {
            \AppLog::record(['type' => 'error_mail', 'user_id' => $order->member_id, 'data_id' => $order->id, 'content' => $e->getMessage()]);
        }

        return true;
    }
}
