<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Repository;
use App\Models\Member;
use App\Http\Resources\OrderResource;

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
        $data = !$member_id ? $this->model::with(['order_products']) : $this->model::with(['order_products'])->where('member_id', Member::decodeSlug($member_id));

        $start_date = data_get($params, 'start_date');
        $end_date = data_get($params, 'end_date');
        if ($start_date && $end_date) {
            $data = $data->where('created_at', '>=', $start_date . ' 00:00:00')->where('created_at', '<=', $end_date . ' 23:59:59');
        }

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10) : $data;

        $data = $data->orderBy('created_at', 'DESC')->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
        }

        return $list;
    }

    public function list($page, array $params = [])
    {
        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model::with(['order_products', 'order_products.product', 'order_products.product.product_images', 'order_products.product_specifications', 'member']) : $this->model::with(['order_products', 'order_products.product', 'order_products.product.product_images', 'order_products.product_specifications', 'member'])->where('merchant_trade_no', 'LIKE', '%' . $keywords . '%')->orWhere('name', 'LIKE', '%' . $keywords . '%');

        $member_id  = data_get($params, 'member_id');
        $data = !$member_id ? $data : $data->where('member_id', Member::decodeSlug($member_id));

        $start_date = data_get($params, 'start_date');
        $end_date = data_get($params, 'end_date');
        if ($start_date && $end_date) {
            $data = $data->where('created_at', '>=', $start_date . ' 00:00:00')->where('created_at', '<=', $end_date . ' 23:59:59');
        }

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10) : $data;

        $data = $data->orderBy('created_at', 'DESC')->get();

        return OrderResource::collection($data);
    }

    public function info($order_id)
    {
        $data = $this->model::with(['order_products'])->find($this->model::decodeSlug($order_id));
        if ($data) {
            return new OrderResource($data);
        }

        return null;
    }

    public function count(array $params = [])
    {
        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model : $this->model->where('merchant_trade_no', 'LIKE', '%' . $keywords . '%')->orWhere('name', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }
}
