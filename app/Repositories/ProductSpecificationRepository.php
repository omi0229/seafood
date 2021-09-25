<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Repository;
use App\Models\ProductSpecifications;
use App\Models\Products;

class ProductSpecificationRepository extends Repository
{
    protected $model, $types;

    public function __construct(ProductSpecifications $model, Products $types)
    {
        $this->model = $model;
        $this->types = $types;
    }

    public function model()
    {
        return 'App\Models\ProductSpecifications';
    }

    public function list($id)
    {

        $data = $this->model->where('product_id', $this->types::decodeSlug($id))->orderBy('created_at', 'DESC')->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['product_id'] = $row->product->hash_id ?? '';
            $list[$key]['product_name'] = $row->product->title ?? '';
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
        $inputs['product_id'] = $this->types::decodeSlug($inputs['product_id']);
        $this->model::create($inputs);
        return true;
    }

    public function updateData($inputs, Request $request)
    {
        $id = $inputs['id'];
        unset($inputs['id']);

        $product_specification = $this->model::find($this->model::decodeSlug($id));
        if ($product_specification) {
            $inputs['product_id'] = $this->types::decodeSlug($inputs['product_id']);
            $product_specification->update($inputs);
            return true;
        }

        return false;
    }
}
