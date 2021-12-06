<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Repository;
use App\Models\Directory;
use App\Models\Products;
use App\Http\Resources\ProductSpecificationResource;

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
        $status = data_get($params, 'status');

        # 有 目錄ID
        $data = $directories_id ? $this->model::with('product')->where('directories_id', Directory::decodeSlug($directories_id)) : $this->model::with('product');

        # 商品是否有開放
        $data = $status === 1 ? $data->where('status', $status) : $data;

        # 有 關鍵字
        $data = !$keywords ? $data : $data->whereHas('product', function (Builder $query) use ($keywords) {
            $query->where('title', 'LIKE', '%' . $keywords . '%');
        });

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * env('PRODUCT_PAGE_ITEM_COUNT', 10) : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(env('PRODUCT_PAGE_ITEM_COUNT', 10))->get() : $data->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['product'] = $row->product->toArray();
            $list[$key]['product']['id'] = $row->product->hash_id;

            $list[$key]['product_specification'] = ProductSpecificationResource::collection($row->product->product_specification)->toResponse(app('request'))->getData(true);

            $row->product->load('product_images');
            $list[$key]['web_img_list'] = $list[$key]['mobile_img_list'] = [];
            $list[$key]['img'] = null;
            foreach ($row->product->product_images as $img_key => $img_row) {
                $type = $img_row->type === 'web' ? 'web_img_list' : 'mobile_img_list';
                $list[$key][$type][$img_key]['path'] = Storage::disk('s3')->exists($img_row->path) ? env('CDN_URL') . $img_row->path : null;

                if ($row->product->product_front_cover_image_id === $img_row->id) {
                    $list[$key]['img'] = $list[$key][$type][$img_key]['path'];
                }
            }

            $web_img_list = collect($list[$key]['web_img_list']);
            $list[$key]['web_img_list'] = $web_img_list->values()->toArray();

            $mobile_img_list = collect($list[$key]['mobile_img_list']);
            $list[$key]['mobile_img_list'] = $mobile_img_list->values()->toArray();

            if (!$list[$key]['product']['product_front_cover_image_id'] && $web_img_list->count() > 0) {
                $list[$key]['img'] = $web_img_list->first()['path'];
            }

            unset($list[$key]['product']['product_front_cover_image_id']);

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

        return ['list' => $this->list($page, ['directories_id' => $type_id, 'status' => 1]), 'all_count' => $all_count, 'page_count' => $page_count, 'page_item_count' => env('PRODUCT_PAGE_ITEM_COUNT', 10)];
    }

    public function apiInfo($id)
    {
        $info = $this->model::with('directory')->where('id', $this->model::decodeSlug($id))->where('status', 1)->get()->first();
        if ($info) {
            $item = $info->toArray();
            $item['id'] = $info->hash_id;
            $item['product'] = $info->product->toArray();
            $item['directories_id'] = $info->directory->hash_id;
            $item['directories_name'] = $info->directory->name;
            $item['product']['description_html'] = nl2br($info->product->description);
            $item['product']['specification'] = $info->product->product_specification;

            $info->product->load('product_images');
            $item['web_img_list'] = $item['mobile_img_list'] = [];
            $item['img'] = null;
            foreach ($info->product->product_images as $key => $row) {
                $type = $row->type === 'web' ? 'web_img_list' : 'mobile_img_list';
                $item[$type][$key]['path'] = Storage::disk('s3')->exists($row->path) ? env('CDN_URL') . $row->path : null;

                if ($info->product->product_front_cover_image_id === $row->id) {
                    $item['img'] = $item[$type][$key]['path'];
                }
            }

            $web_img_list = collect($item['web_img_list']);
            $item['web_img_list'] = $web_img_list->values()->toArray();

            $mobile_img_list = collect($item['mobile_img_list']);
            $item['mobile_img_list'] = $mobile_img_list->values()->toArray();

            if (!$item['product']['product_front_cover_image_id'] && $web_img_list->count() > 0) {
                $item['img'] = $web_img_list->first()['path'];
            }

            unset($item['product']['product_front_cover_image_id']);

            return $item;
        }

        return false;
    }

    public function searchList($page, $keywords = null)
    {
        $data = $this->model->where('status', 1);

        # 有 關鍵字
        $data = !$keywords ? $data : $data->whereHas('product', function (Builder $query) use ($keywords) {
            $query->where('title', 'LIKE', '%' . $keywords . '%');
        });

        # 此搜尋結果全部數量
        $all_count = $data->count();

        # 此搜尋結果共有幾頁
        $page_count = ceil($all_count / env('PRODUCT_PAGE_ITEM_COUNT', 10));

        $page = $page ? $page : 1;

        $params = ['status' => 1];
        if ($keywords) {
            $params['keywords'] = $keywords;
        }

        return ['list' => $this->list($page, $params), 'all_count' => $all_count, 'page_count' => $page_count, 'page_item_count' => (int)env('PRODUCT_PAGE_ITEM_COUNT', 10)];
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
