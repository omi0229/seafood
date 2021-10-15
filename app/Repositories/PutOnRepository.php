<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function apiList($type_id, $page = null)
    {
        $data = $this->model->where('directories_id', Directory::decodeSlug($type_id))->where('status', 1);

        # 此分類的全部數量
        $all_count = $data->count();

        # 此分類共有幾頁
        $page_count = ceil($all_count / env('PRODUCT_PAGE_ITEM_COUNT', 10));

        $page = $page ? $page : 1;

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * env('PRODUCT_PAGE_ITEM_COUNT', 10) : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(env('PRODUCT_PAGE_ITEM_COUNT', 10))->get() : $data->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;

            $web_img_path = $row->product->web_img && Storage::disk('s3')->exists($row->product->web_img) ? Storage::disk('s3')->url($row->product->web_img) : null;
            $mobile_img_path = $row->product->mobile_img && Storage::disk('s3')->exists($row->product->mobile_img) ? Storage::disk('s3')->url($row->product->web_img) : null;

            $list[$key]['product'] = $row->product->toArray();
            $list[$key]['product']['id'] = $row->product->hash_id;
            $list[$key]['web_img_path'] = $list[$key]['product']['web_img_path'] = $web_img_path;
            $list[$key]['mobile_img_path'] = $list[$key]['product']['mobile_img_path'] = $mobile_img_path;
        }

        return ['list' => $list, 'all_count' => $all_count, 'page_count' => $page_count, 'page_item_count' => env('PRODUCT_PAGE_ITEM_COUNT', 10)];
    }

    public function apiInfo($id)
    {
        $info = $this->model->where('id', $this->model::decodeSlug($id))->where('status', 1)->get()->first();
        $item = $info->toArray();
        $item['id'] = $info->hash_id;
        $item['product'] = $info->product->toArray();
        $item['product']['id'] = $info->product->hash_id;
        $item['product']['description_html'] = nl2br($info->product->description);
        $item['product']['specification'] = $info->product->product_specification;
        $item['product']['web_img_path'] = $info->product->web_img && Storage::disk('s3')->exists($info->product->web_img) ? Storage::disk('s3')->url($info->product->web_img) : null;
        $item['product']['mobile_img_path'] = $info->product->mobile_img && Storage::disk('s3')->exists($info->product->mobile_img) ? Storage::disk('s3')->url($info->product->mobile_img) : null;
        return $item;
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
