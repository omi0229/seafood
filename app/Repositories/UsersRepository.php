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

        $data = !$keywords ? $this->model : $this->model->where('account', 'LIKE', '%' . $keywords . '%');

        $data = $data->skip($start)->take(10)->get();

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

        $data = !$keywords ? $this->model : $this->model->where('account', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }
}
