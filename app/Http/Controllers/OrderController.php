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

    protected $service_name = 'order';

    protected $request, $model, $repository, $services;

    public function __construct(Request $request, Orders $model, OrderRepository $repository, OrderServices $services)
    {
        $this->request = $request;
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function ecpayReturn()
    {
        return 1;
    }

    public function ecpayResult(NotificationRepository $notification_repository)
    {
        $inputs = $this->request->all();
        if (data_get($inputs, 'CustomField1')) {
            $order_id = Orders::decodeSlug($inputs['CustomField1']);
            $order = $this->repository->find($order_id);
            $this->repository->update($order_id, ['payment_status' => 1]);
//            $notification_repository->create(['member_id' => $order->member_id, 'type' => 'order_success', 'text' => json_encode(['order_id' => $order_id])]);
        }

        header("Location: " . env('FRONT_PAGE_URL') . 'account/record');
        exit;
    }
}
