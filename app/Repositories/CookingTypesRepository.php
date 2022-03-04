<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Http\Request;

class CookingTypesRepository extends Repository
{
    public function model()
    {
        return 'App\Models\CookingTypes';
    }

    public function list($page, array $params = [])
    {

        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model->select(['id', 'name', 'location']) : $this->model->select(['id', 'name', 'location'])->where('name', 'LIKE', '%' . $keywords . '%');

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10) : $data;

        $data = $data->orderBy('location')->orderBy('id')->get();

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

        $data = !$keywords ? $this->model : $this->model->where('name', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }
}
