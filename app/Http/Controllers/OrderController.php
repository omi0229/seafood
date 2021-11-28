<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\Orders;
use App\Repositories\OrderRepository;
use App\Services\OrderServices;
use App\Repositories\NotificationRepository;

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
}
