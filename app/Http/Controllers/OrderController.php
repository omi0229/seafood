<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\Orders;
use App\Models\DiscountRecord;
use App\Repositories\OrderRepository;
use App\Services\OrderServices;

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
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $this->repository->update($this->model::decodeSlug($id), $inputs);

        return response()->json(['status' => true, 'message' => '編輯成功']);
    }

    public function export($type) {
        return $this->services->exportOrders($type);
    }

    public function ecpayReturn()
    {
        $inputs = $this->request->all();
        # 用ATM付款
        if (data_get($inputs, 'PaymentType') && $inputs['PaymentType'] !== 'Credit_CreditCard') {
            $order_id = Orders::decodeSlug($inputs['CustomField1']);
            $order = $this->repository->find($order_id);
            if ((int)$inputs['RtnCode'] === 1) {
                $this->repository->update($order_id, ['payment_status' => 1]);

                # 如果有用優惠劵並且付款成功
                if (data_get($inputs, 'CustomField2')) {
                    $coupon_record_id = $inputs['CustomField2'];
                    $record = DiscountRecord::find(DiscountRecord::decodeSlug($coupon_record_id));
                    if ($record) {
                        $record->used_at = now();
                        $record->save();
                    }
                }

            } else {
                $this->repository->update($order_id, ['payment_status' => -2]);
            }

            \AppLog::record([
                'type' => 'payment',
                'user_id' => $order->member_id,
                'data_id' => $order_id,
                'content' => json_encode([
                    'RtnCode' => $inputs['RtnCode'],
                    'RtnMsg' => $inputs['RtnMsg'],
                    'PaymentType' => $inputs['PaymentType'],
                    'TradeAmt' => $inputs['TradeAmt'],
                    'PaymentDate' => $inputs['PaymentDate'],
                ]),
            ]);
        }

        return "1|OK";
    }

    # 信用卡繳費回傳結果
    public function ecpayResult()
    {
        $inputs = $this->request->all();
        if (data_get($inputs, 'CustomField1')) {
            $order_id = Orders::decodeSlug($inputs['CustomField1']);
            $order = $this->repository->find($order_id);
            $this->repository->update($order_id, [
                'payment_method' => 1,
                'payment_status' => 1,
                'TradeNo' => null,
                'BankCode' => null,
                'vAccount' => null,
                'ExpireDate' => null,
            ]);

            # 如果有用優惠劵並且付款成功
            if (data_get($inputs, 'CustomField2')) {
                $coupon_record_id = $inputs['CustomField2'];
                $record = DiscountRecord::find(DiscountRecord::decodeSlug($coupon_record_id));
                if($record) {
                    $record->orders_id = $order_id;
                    $record->used_at = now();
                    $record->save();
                }
            }

            \AppLog::record([
                'type' => 'payment',
                'user_id' => $order->member_id,
                'data_id' => $order_id,
                'content' => json_encode([
                    'PaymentType' => $inputs['PaymentType'],
                    'TradeAmt' => $inputs['TradeAmt'],
                    'PaymentDate' => $inputs['PaymentDate'],
                ]),
            ]);

//            $this->mxp_line_notify('testtest');
        }

        header("Location: " . env('FRONT_PAGE_URL') . 'account/record');
        exit;
    }

    public function mxp_line_notify($msg)
    {
        if ($msg == "") {
            return;
        }

        $token = 'O5lWvABYgyYCU7TXI5B1iZ';

        $body = array(
            'message' => PHP_EOL . $msg, //先斷行，避免跟 Bot 稱呼黏在一起
        );
        // 授權方式
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token,
        );
        $url = 'https://notify-api.line.me/api/notify';

        $ch = curl_init();

        $params = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => TRUE,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($body),
        );

        curl_setopt_array($ch, $params);

        if (!$result = curl_exec($ch)) {
            if ($errno = curl_errno($ch)) {
                $error_message = curl_strerror($errno);

                // echo "cURL error ({$errno}):\n {$error_message}";
                curl_close($ch);
                return FALSE;
            }
        } else {
            curl_close($ch);
            return TRUE;
        }
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
}
