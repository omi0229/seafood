<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Repositories\OrderRepository;
use App\Repositories\NotificationRepository;

class OrderController extends Controller
{
    protected $request, $repository;

    public function __construct(Request $request, OrderRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    public function ecpayReturn()
    {
        return 1;
    }

    public function ecpayResult(NotificationRepository $notification_repository)
    {
        $inputs = $this->request->all();
        if (data_get($inputs, 'CustomField1') && data_get($inputs, 'MerchantTradeNo')) {
            $order_id = Orders::decodeSlug($inputs['CustomField1']);
            $order = $this->repository->find($order_id);
            $this->repository->update($order_id, ['merchant_trade_no' => $inputs['MerchantTradeNo'], 'payment_status' => 1]);
            $notification_repository->create(['member_id' => $order->member_id, 'type' => 'order_success', 'text' => json_encode(['order_id' => $order_id])]);
        }

        header("Location: " . env('FRONT_PAGE_URL'));
    }
}
