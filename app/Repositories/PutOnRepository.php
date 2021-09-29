<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Repository;
use App\Models\Directory;
use App\Models\Products;

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
        $data = $directories_id ? $this->model::with('product')->where('directories_id', Directory::decodeSlug($directories_id)) : $this->model::with('product');

        # 有 關鍵字
        $data = !$keywords ? $data : $data->whereHas('product', function (Builder $query) use ($keywords) {
            $query->where('title', 'LIKE', '%' . $keywords . '%');
        });

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10)->get() : $data->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['product'] = $row->product->toArray();
            $list[$key]['product']['id'] = $row->product->hash_id;
        }

        return $list;
    }

    public function count(array $params = [])
    {
        $keywords = data_get($params, 'keywords');
        $directories_id = data_get($params, 'directories_id');

        # 有 目錄ID
        $data = $directories_id ? $this->model->where('directories_id', Directory::decodeSlug($directories_id)) : $this->model;

        $data = !$keywords ? $data : $data->where('name', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }

    public function insertData($inputs)
    {
        $directories_id = Directory::decodeSlug($inputs['directories_id']);

        $list = $this->model->where('directories_id', $directories_id)->get();
        foreach ($list as $model) {
            $count = collect($inputs['check_list'])
                ->map(function ($c) {
                    return [
                        'id' => Products::decodeSlug($c['id']),
                    ];
                })
                ->filter(function ($c) use ($model) {

                    if($c['id'] == $model['product_id']){
                        return true;
                    }

                    return false;
                })
                ->count();

            if($count <= 0){
                $model->delete();
            }
        }

        foreach ($inputs['check_list'] as $row) {
            $product_id = Products::decodeSlug($row['id']);
            $count = $this->model->where('directories_id', $directories_id)->where('product_id', $product_id)->count();
            if ($count <= 0) {
                $this->model->create([
                    'directories_id' => $directories_id,
                    'product_id' => $product_id,
                ]);
            }
        }

        return true;
    }

    public function updateData($inputs)
    {
        $list = collect($inputs['list'])
            ->map(function ($p) {
                return $this->model::decodeSlug($p['id']);
            })
            ->toArray();
        unset($inputs['list']);
        $this->model->whereIn('id', $list)->update($inputs);

        return true;
    }
}
