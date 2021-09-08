<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Http\Request;

class RolesRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Role';
    }

    public function list($page, array $params = [])
    {

        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model : $this->model->where('name', 'LIKE', '%' . $keywords . '%');
        $this->model->load(['permissions']);

        if ($page !== 'all' && is_numeric($page)) {
            $start = ($page - 1) * 10;
            $data = $data->skip($start)->take(10)->get();
        } else {
            $data = $data->get();
        }

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['permissions'] = $row->permissions;
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
