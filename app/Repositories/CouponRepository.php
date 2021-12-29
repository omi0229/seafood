<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ProductSpecifications;

class CouponRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Coupon';
    }

    public function list($page, array $params = [])
    {
        $keywords = data_get($params, 'keywords');

        $data = $this->model::with([
            'coupon_records' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'coupon_records.order',
        ])->withCount(['coupon_records']);

        $data = !$keywords ? $data : $data->where('title', 'LIKE', '%' . $keywords . '%')->orWhere('fixed_name', 'LIKE', '%' . $keywords . '%');

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10)->get() : $data->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['product_specifications_list'] = $row->product_specifications->map(function($v) {
                return $v->hash_id;
            })->toArray();
        }

        return $list;
    }

    public function count(array $params = [])
    {
        $keywords = data_get($params, 'keywords');
        $data = !$keywords ? $this->model : $this->model->where('title', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }

    public function insertData($inputs)
    {
        unset($inputs['id']);

        $model = $this->model::create($inputs);

        if ($model) {
            $data = [];
            for ($r = 0; $r < $inputs['records']; $r++) {
                array_push($data, ['type' => 'coupon', 'discount_codes_id' => $model->id, 'created_at' => now()]);
            }

            if (count($data) > 0) {
                $model->coupon_records()->insert($data);
            }

            # 同步已選擇產品資料
            $product_specifications_list = collect($inputs['product_specifications_list'])->map(function($v) {
                return ProductSpecifications::decodeSlug($v['id']);
            })->toArray();

            $model->product_specifications()->sync($product_specifications_list);
        }

        return true;
    }

    public function updateData($inputs)
    {
        $id = data_get($inputs, 'id');
        $records = data_get($inputs, 'records');
        $product_specifications_list = data_get($inputs, 'product_specifications_list');

        $model = $this->find($this->model::decodeSlug($id));
        if ($model) {
            $data = [];
            for ($r = 0; $r < $records; $r++) {
                array_push($data, ['type' => 'coupon', 'discount_codes_id' => $model->id, 'created_at' => now()]);
            }

            if (count($data) > 0) {
                $model->coupon_records()->insert($data);
            }

            $product_specifications_list = collect($product_specifications_list)->map(function ($v) {
                return ProductSpecifications::decodeSlug($v['id']);
            })->toArray();

            $model->product_specifications()->sync($product_specifications_list);
        }

        return true;
    }
}
