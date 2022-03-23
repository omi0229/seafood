<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Repository;
use App\Models\Member;
use App\Http\Resources\OrderResource;
use App\Http\Resources\RecordListResource;

class OrderRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Orders';
    }

    # 前臺 訂單紀錄查詢
    public function recordList($page, array $params = [])
    {
        $member_id = data_get($params, 'member_id');
        $data = !$member_id ? $this->model::with(['order_products', 'discount_record.discount_codes', 'discount_record.coupon']) : $this->model::with(['order_products', 'discount_record.discount_codes', 'discount_record.coupon'])->where('member_id', Member::decodeSlug($member_id));

        $start_date = data_get($params, 'start_date');
        $end_date = data_get($params, 'end_date');
        if ($start_date && $end_date) {
            $data->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        }

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10) : $data;

        $data = $data->orderBy('created_at', 'DESC')->get();

        return RecordListResource::collection($data);
    }

    public function list($page, array $params = [])
    {
        $data = $this->model::with([
            'order_products',
            'order_products.product',
            'order_products.product.product_images',
            'order_products.product_specifications',
            'member',
            'discount_record',
            'discount_record.discount_codes',
            'discount_record.coupon'
        ]);

        $data = $this->searchCondition($data, $params);

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10) : $data;

        $data = $data->orderBy('created_at', 'DESC')->get();

        return OrderResource::collection($data);
    }

    public function info($order_id)
    {
        $data = $this->model::with(['order_products', 'discount_record', 'discount_record.discount_codes', 'discount_record.coupon'])->find($this->model::decodeSlug($order_id));

        return $data ? new OrderResource($data) : null;
    }

    public function count(array $params = [])
    {
        return $this->searchCondition($this->model, $params)->count();
    }

    public function searchCondition($data, $params)
    {
        # 關鍵字
        $keywords = data_get($params, 'keywords');
        if ($keywords) {
            $data = $data->where(function ($query) use ($keywords) {
                $query->where('merchant_trade_no', 'LIKE', '%' . $keywords . '%');
                $query->orWhere('name', 'LIKE', '%' . $keywords . '%');
            });
        }

        # 訂單狀態
        $order_status = data_get($params, 'order_status');
        $data = $order_status === null ? $data : $data->where('order_status', $order_status);

        # 付款狀態
        $payment_status = data_get($params, 'payment_status');
        $data = $payment_status === null ? $data : $data->where('payment_status', $payment_status);

        # 會員編號
        $member_id  = data_get($params, 'member_id');
        $data = !$member_id ? $data : $data->where('member_id', Member::decodeSlug($member_id));

        # 訂購時間範圍
        $start_date = data_get($params, 'start_date');
        $end_date = data_get($params, 'end_date');
        if ($start_date && $end_date) {
           $data = $data->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        }

        return $data;
    }
}
