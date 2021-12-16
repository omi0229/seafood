<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Repository;

class DiscountCodeRepository extends Repository
{
    public function model()
    {
        return 'App\Models\DiscountCode';
    }

    public function list($page, array $params = [])
    {
        $keywords = data_get($params, 'keywords');
        $data = !$keywords ? $this->model::with('children') : $this->model::with('children')->where('title', 'LIKE', '%' . $keywords . '%');

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10) : $data;

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
        }

        return $list;
    }

    public function count(array $params = [])
    {
        $keywords = data_get($params, 'keywords');
        $data = !$keywords ? $this->model : $this->model->where('title', 'LIKE', '%' . $keywords . '%');

        $floor = data_get($params, 'floor');
        $data = !$floor ? $data : $data->where('floor', $floor);

        return $data->count();
    }

    public function insertData($inputs)
    {
        unset($inputs['id']);

        if (data_get($inputs, 'parents_id')) {
            $inputs['parents_id'] = $this->model::decodeSlug($inputs['parents_id']);
        }

        if (data_get($inputs, 'end_date')) {
            $inputs['end_date'] = substr($inputs['end_date'], 0, 10) . ' 23:59:59';
        }

        $model = $this->model::create($inputs);

        return true;
    }
}
