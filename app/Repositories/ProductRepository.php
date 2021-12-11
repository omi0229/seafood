<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Products;
use App\Models\ProductTypes;
use App\Models\ProductImages;
use App\Repositories\Repository;
use App\Repositories\ProductImageRepository;

class ProductRepository extends Repository
{
    protected $model, $types, $images, $image_repository;

    public function __construct(Products $model, ProductTypes $types, ProductImages $images, ProductImageRepository $image_repository)
    {
        $this->model = $model;
        $this->types = $types;
        $this->images = $images;
        $this->image_repository = $image_repository;
    }

    public function model()
    {
        return 'App\Models\Products';
    }

    public function list($page, array $params = [])
    {
        $keywords = data_get($params, 'keywords');
        $product_types_id = data_get($params, 'product_types_id');
        $show_status = data_get($params, 'show_status');

        # 有 產品分類
        $data = $product_types_id ? $this->model::with(['product_types', 'product_images'])->where('product_types_id', ProductTypes::decodeSlug($product_types_id)) : $this->model::with(['product_types', 'product_images']);

        # 有 是否於上架管理顯示
        $data = $show_status !== null ? $data->where('show_status', $show_status) : $data;

        # 有 關鍵字
        $data = $keywords ? $data->where('title', 'LIKE', '%' . $keywords . '%') : $data;

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10)->get() : $data->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['product_types_id'] = $row->product_types->hash_id ?? '';
            $list[$key]['product_types_name'] = $row->product_types->name ?? '';
            $list[$key]['product_front_cover_image_id'] = $row->product_images->where('id', $row->product_front_cover_image_id)->first()->hash_id ?? '';
            $list[$key]['product_mobile_front_cover_image_id'] = $row->product_images->where('id', $row->product_mobile_front_cover_image_id)->first()->hash_id ?? '';

            $list[$key]['web_img_list'] = $list[$key]['mobile_img_list'] = [];
            foreach ($row->product_images as $img_key => $img_row) {
                $type = $img_row->type === 'web' ? 'web_img_list' : 'mobile_img_list';
                $list[$key][$type][$img_key]['id'] = $img_row->hash_id;
                $list[$key][$type][$img_key]['name'] = $img_row->name;
                $list[$key][$type][$img_key]['product_id'] = $img_row->product_id;
                $list[$key][$type][$img_key]['delete'] = 0;
                $list[$key][$type][$img_key]['path'] = Storage::disk('s3')->exists($img_row->path) ? env('CDN_URL') . $img_row->path : null;
                $list[$key][$type][$img_key]['type'] = $img_row->type;
            }

            $list[$key]['web_img_list'] = collect($list[$key]['web_img_list'])->values()->toArray();
            $list[$key]['mobile_img_list'] = collect($list[$key]['mobile_img_list'])->values()->toArray();
        }

        return $list;
    }

    public function apiData($type_id, $page = null)
    {
        $data = $this->model->where('product_types_id', ProductTypes::decodeSlug($type_id))->where('status', 1);

        # 此分類的全部數量
        $all_count = $data->count();

        # 此分類共有幾頁
        $page_count = ceil($all_count / 10);

        $page = $page ? $page : 1;

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10)->get() : $data->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['product_types_id'] = $row->product_types->hash_id ?? '';
            $list[$key]['product_types_name'] = $row->product_types->name ?? '';
            $list[$key]['web_img_path'] = $row->web_img && Storage::disk('s3')->exists($row->web_img) ? env('CDN_URL') . $row->web_img : null;
            $list[$key]['mobile_img_path'] = $row->mobile_img && Storage::disk('s3')->exists($row->mobile_img) ? env('CDN_URL') . $row->mobile_img : null;
        }

        return ['list' => $list, 'all_count' => $all_count, 'page_count' => $page_count];
    }

    public function apiInfo($id)
    {
        $info = $this->model->where('id', News::decodeSlug($id))->where('status', 1)->get()->first();
        $item = $info->toArray();
        $item['web_img_path'] = $info->web_img && Storage::disk('s3')->exists($info->web_img) ? env('CDN_URL') . $info->web_img : null;
        $item['mobile_img_path'] = $info->mobile_img && Storage::disk('s3')->exists($info->mobile_img) ? env('CDN_URL') . $info->mobile_img : null;
        return $item;
    }

    public function count(array $params = [])
    {
        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model : $this->model->where('title', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }

    private function __setFrontPageCoverImage(Products $model, $product_front_cover_image_array, $product_mobile_front_cover_image_array)
    {
        ### 新增產品圖片
        # web
        $array = $this->image_repository->createImage('web_new_img_list', $model->id, 'web');
        if (isset($product_front_cover_image_array[0]) && $product_front_cover_image_array[0] === 'new') {
            $key = (int)$product_front_cover_image_array[1];
            $model->product_front_cover_image_id = $array[$key];
            $model->save();
        }

        # mobile
        $array = $this->image_repository->createImage('mobile_new_img_list', $model->id, 'mobile');
        if (isset($product_mobile_front_cover_image_array[0]) && $product_mobile_front_cover_image_array[0] === 'new') {
            $key = (int)$product_mobile_front_cover_image_array[1];
            $model->product_mobile_front_cover_image_id = $array[$key];
            $model->save();
        }
    }

    public function insertData($inputs, Request $request)
    {
        unset($inputs['id']);
        $inputs['product_types_id'] = $this->types::decodeSlug($inputs['product_types_id']);

        # web
        $product_front_cover_image_array = explode('.', $inputs['product_front_cover_image_id']);
        unset($inputs['product_front_cover_image_id']);

        # mobile
        $product_mobile_front_cover_image_array = explode('.', $inputs['product_mobile_front_cover_image_id']);
        unset($inputs['product_mobile_front_cover_image_id']);

        $model = $this->model::create($inputs);

        # 設定前台封面圖
        $this->__setFrontPageCoverImage($model, $product_front_cover_image_array, $product_mobile_front_cover_image_array);

        return true;
    }

    public function updateData($inputs, Request $request)
    {
        $product_id = $inputs['id'];

        $web_img_delete_list = data_get($request->all(), 'web_img_delete_list') ? explode(',', data_get($request->all(), 'web_img_delete_list')) : [];
        $mobile_img_delete_list = data_get($request->all(), 'mobile_img_delete_list') ? explode(',', data_get($request->all(), 'mobile_img_delete_list')) : [];

        unset($inputs['id']);

        $product = $this->model::find($this->model::decodeSlug($product_id));
        if ($product) {
            $inputs['product_types_id'] = $this->types::decodeSlug($inputs['product_types_id']);

            # web
            $product_front_cover_image_array = explode('.', $inputs['product_front_cover_image_id']);

            if (isset($product_front_cover_image_array[0]) && $product_front_cover_image_array[0] === 'new') {
                unset($inputs['product_front_cover_image_id']);
            } else {
                $inputs['product_front_cover_image_id'] = $this->images::decodeSlug($inputs['product_front_cover_image_id']);
            }

            # mobile
            $product_mobile_front_cover_image_array = explode('.', $inputs['product_mobile_front_cover_image_id']);

            if (isset($product_mobile_front_cover_image_array[0]) && $product_mobile_front_cover_image_array[0] === 'new') {
                unset($inputs['product_mobile_front_cover_image_id']);
            } else {
                $inputs['product_mobile_front_cover_image_id'] = $this->images::decodeSlug($inputs['product_mobile_front_cover_image_id']);
            }

            $product->update($inputs);

            # 設定前台封面圖
            $this->__setFrontPageCoverImage($product, $product_front_cover_image_array, $product_mobile_front_cover_image_array);

            if (count($web_img_delete_list) > 0) {
                $delete_array = $this->images->whereIn('id', array_map([$this->images, 'decodeSlug'], $web_img_delete_list))->get();
                foreach ($delete_array as $item) {
                    Storage::disk('s3')->delete($item->path);
                    $item->delete();
                }
            }

            if (count($mobile_img_delete_list) > 0) {
                $delete_array = $this->images->whereIn('id', array_map([$this->images, 'decodeSlug'], $mobile_img_delete_list))->get();
                foreach ($delete_array as $item) {
                    Storage::disk('s3')->delete($item->path);
                    $item->delete();
                }
            }

            return true;
        }

        return false;
    }
}
