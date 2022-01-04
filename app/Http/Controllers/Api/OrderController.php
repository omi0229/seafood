<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Orders;
use App\Models\Freight;
use App\Repositories\OrderRepository;
use App\Repositories\OrderProductRepository;
use App\Repositories\MembersRepository;
use App\Services\OrderServices;
use App\Services\FreightServices;
use App\Services\ProductSpecificationServices;

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
            $receiver['freight_id'] = Freight::decodeSlug($receiver['freight_id']);
            $order = $this->repository->create($receiver);
            $list = data_get($this->request->all(), 'list');
            if($list) {
                $order_product_repository->insertData($order->id, $list);
            }

            $time = now();
            $order_no = 'o' . substr($time->format('YmdHis'), 2) . str_pad($order->id,6,"0",STR_PAD_LEFT);
            $this->repository->update($order->id, ['merchant_trade_no' => $order_no]);

            #扣掉庫存
            ProductSpecificationServices::inventoryCalculation($list);
            \AppLog::record(['type' => 'inventory-reduction', 'user_id' => $order->member_id, 'data_id' => $order->id, 'content' => json_encode($list)]);

            $ecpay = null;
            $linepay = null;
            if((int)$order->payment_method === 3) { # line pay
                $linepay = OrderServices::linepayInit($order_no, $list, $order->hash_id, $receiver['freight'], null, $this->request->all());
            } else {
                $ecpay = OrderServices::ecpayForm($order_no, $time, $order->payment_method, $list, $order->hash_id, $receiver['freight'], null, $this->request->all());
            }

            return response()->Json(['status' => true, 'message' => '訂單新增成功', 'ecpay' => $ecpay, 'linepay' => $linepay]);
        }
        return response()->Json(['status' => false, 'message' => '訂單新增失敗']);
    }

    public function payment()
    {
        $order_id = data_get($this->request->all(), 'order_id');
        $list = data_get($this->request->all(), 'list');
        $payment_method = data_get($this->request->all(), 'payment_method');
        if ($order_id && $list && is_array($list) && $payment_method) {
            $time = now();
            $order = Orders::find(Orders::decodeSlug($order_id));
            $order_no = 'o' . substr($time->format('YmdHis'), 2) . str_pad($order->id, 6, "0", STR_PAD_LEFT);
            $this->repository->update($order->id, ['merchant_trade_no' => $order_no]);

            $ecpay = null;
            $linepay = null;
            if((int)$order->payment_method === 3) { # line pay
                $linepay = OrderServices::linepayInit($order_no, $list, $order_id, $order->freight, 'make_up', $this->request->all());
            } else {
                $ecpay = OrderServices::ecpayForm($order_no, $time, $payment_method, $list, $order_id, $order->freight, 'make_up', $this->request->all());
            }

            return response()->Json(['status' => true, 'message' => '付款資料建構成功', 'ecpay' => $ecpay, 'linepay' => $linepay]);
        }

        return response()->Json(['status' => false, 'message' => '付款資料建構失敗']);

    }

    public function list($member_id, $page)
    {
        $params = ['member_id' => $member_id];
        $inputs = $this->request->all();
        if(data_get($inputs, 'start_date') && data_get($inputs, 'end_date')) {
            $params['start_date'] = $inputs['start_date'];
            $params['end_date'] = $inputs['end_date'];
        }
        return response()->Json(['status' => true, 'message' => '訂單查詢成功', 'data' => $this->repository->recordList($page, $params)]);
    }

    public function info($order_id) {
        return response()->Json(['status' => true, 'message' => '訂單查詢成功', 'data' => $this->repository->info($order_id)]);
    }

    public function freight(FreightServices $services)
    {
        return response()->Json(['status' => true, 'message' => '取得運費列表成功', 'data' => $services->getFeightList()]);
    }
}
