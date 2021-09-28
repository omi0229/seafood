<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Repository;
use App\Models\Products;
use App\Models\ProductTypes;

class ProductRepository extends Repository
{
    protected $model, $types;

    public function __construct(Products $model, ProductTypes $types)
    {
        $this->model = $model;
        $this->types = $types;
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
        $data = $product_types_id ? $this->model->where('product_types_id', ProductTypes::decodeSlug($product_types_id)) : $this->model;

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

            $list[$key]['web_img_path'] = $row->web_img ? asset('storage/' . $row->web_img) : null;
            $list[$key]['mobile_img_path'] = $row->mobile_img ? asset('storage/' . $row->mobile_img) : null;
        }

        return $list;
    }

    public function count(array $params = [])
    {
        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model : $this->model->where('title', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }

    public function insertData($inputs, Request $request)
    {
        unset($inputs['id']);
        $inputs['product_types_id'] = $this->types::decodeSlug($inputs['product_types_id']);

        if ($request->hasFile('web_img')) {
            $inputs['web_img'] = $request->file('web_img')->store('product');
        } else {
            $inputs['web_img_name'] = null;
            $inputs['web_img'] = null;
        }

        if ($request->hasFile('mobile_img')) {
            $inputs['mobile_img'] = $request->file('mobile_img')->store('product');
        } else {
            $inputs['mobile_img_name'] = null;
            $inputs['mobile_img'] = null;
        }

        $this->model::create($inputs);

        return true;
    }

    public function updateData($inputs, Request $request)
    {
        $product_id = $inputs['id'];

        $web_img_delete = (int)$request->all()['web_img_delete'] ?? 0;
        $mobile_img_delete = (int)$request->all()['mobile_img_delete'] ?? 0;

        unset($inputs['id']);

        $product = $this->model::find($this->model::decodeSlug($product_id));
        if ($product) {
            $inputs['product_types_id'] = $this->types::decodeSlug($inputs['product_types_id']);

            if (!$web_img_delete) {
                if ($request->hasFile('web_img')) {
                    $inputs['web_img'] = $request->file('web_img')->store('product');
                } else {
                    $inputs['web_img_name'] = !$product['web_img'] ? null : $inputs['web_img_name'];
                }
            } else {
                $inputs['web_img_name'] = null;
                $inputs['web_img'] = null;
                Storage::disk('local')->delete($product->web_img);
            }

            if (!$mobile_img_delete) {
                if ($request->hasFile('mobile_img')) {
                    $inputs['mobile_img'] = $request->file('mobile_img')->store('product');
                } else {
                    $inputs['mobile_img_name'] = !$product['mobile_img'] ? null : $inputs['mobile_img_name'];
                }
            } else {
                $inputs['mobile_img_name'] = null;
                $inputs['mobile_img'] = null;
                Storage::disk('local')->delete($product->mobile_img);
            }

            $product->update($inputs);

            return true;
        }

        return false;
    }
}
