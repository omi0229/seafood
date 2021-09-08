<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Http\Request;

class UsersRepository extends Repository
{
    public function model()
    {
        return 'App\Models\User';
    }

    public function list($page, array $params = [])
    {
        $start = ($page - 1) * 10;
        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model->load('roles') : $this->model->load('roles')->where('account', 'LIKE', '%' . $keywords . '%');

        $data = $data->skip($start)->take(10)->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;

            $role = $row->roles->first();
            $list[$key]['role_id'] = $role->hash_id ?? '';
            $list[$key]['role_name'] = $role->name ?? '';
        }

        return $list;
    }

    public function count(array $params = [])
    {
        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model : $this->model->where('account', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }
}
