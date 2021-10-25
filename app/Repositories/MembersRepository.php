<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Http\Request;

class MembersRepository extends Repository
{
    protected $request;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    public function model()
    {
        return 'App\Models\Member';
    }

    public function list($page, array $params = [])
    {
        $keywords = data_get($params, 'keywords');
        $active = data_get($params, 'active');

        $data = !$keywords ? $this->model : $this->model->where('cellphone', 'LIKE', '%' . $keywords . '%')->orWhere('name', 'LIKE', '%' . $keywords . '%');

        # 有 是否於上架管理顯示
        $data = $active ? $data->where('active', $active) : $data;

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10) : $data;

        $data = $data->orderBy('created_at', 'DESC')->get();

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

        $data = !$keywords ? $this->model : $this->model->where('cellphone', 'LIKE', '%' . $keywords . '%')->orWhere('name', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }
}
