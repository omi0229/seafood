<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Models\Directory;

class PutOnRepository extends Repository
{
    public function model()
    {
        return 'App\Models\PutOn';
    }

    public function list($page, array $params = [])
    {
        $keywords = data_get($params, 'keywords');
        $directories_id = data_get($params, 'directories_id');

        # 有 目錄ID
        $data = $directories_id ? $this->model->where('directories_id', Directory::decodeSlug($directories_id)) : $this->model;

        # 有 關鍵字
        $data = !$keywords ? $data : $data->where('name', 'LIKE', '%' . $keywords . '%');

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10)->get() : $data->get();

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
