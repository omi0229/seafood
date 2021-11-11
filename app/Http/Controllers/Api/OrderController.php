<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Member;
use App\Repositories\OrderRepository;
use App\Repositories\OrderProductRepository;
use App\Repositories\MembersRepository;
use App\Services\OrderServices;

class OrderController extends Controller
{
    protected $request, $repository;

    public function __construct(Request $request, OrderRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    public function create(MembersRepository $members_repository, OrderProductRepository $order_product_repository)
    {
        $member_id = data_get($this->request->all(), 'member_id');
        $synchronize = data_get($this->request->all(), 'synchronize');
        if ($synchronize) {
            $form = data_get($this->request->all(), 'form');
            if ($form && $member_id) {
                $members_repository->update(Member::decodeSlug($member_id), $form);
            }
        }

        $receiver = data_get($this->request->all(), 'receiver');
        if ($receiver && $member_id) {
            $receiver['member_id'] = Member::decodeSlug($member_id);
            $order = $this->repository->create($receiver);
            $list = data_get($this->request->all(), 'list');
            if($list) {
                $order_product_repository->insertData($order->id, $list);
            }

            $time = now();
            $order_no = 'o' . substr($time->format('YmdHis'), 2) . str_pad($order->id,6,"0",STR_PAD_LEFT);

            $ecpay = OrderServices::ecpayForm($order_no, $time, $list, $order->hash_id);

            return response()->Json(['status' => true, 'message' => '訂單新增成功', 'ecpay' => $ecpay]);
        }
        return response()->Json(['status' => false, 'message' => '訂單新增失敗']);
    }
}
