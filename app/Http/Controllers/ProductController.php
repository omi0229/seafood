<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\Products;
use App\Repositories\ProductRepository;
use App\Services\ProductServices;

class ProductController extends Controller
{
    use General;

    protected $service_name = 'product';

    protected $model, $repository, $services;

    public function __construct(Products $model, ProductRepository $repository, ProductServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function insert(Request $request)
    {
        $inputs = $request->only('id', 'product_types_id', 'title', 'content', 'keywords', 'description', 'web_img_name', 'mobile_img_name', 'sales_status', 'show_status');

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        # 新增資料
        $this->repository->insertData($inputs, $request);

        return response()->json(['status' => true, 'message' => '新增成功']);
    }

    public function update(Request $request)
    {
        if (!data_get($request->all(), 'id')) {
            return response()->json(['status' => false, 'message' => '修改失敗']);
        }

        $inputs = $request->only('id', 'product_types_id', 'title', 'content', 'keywords', 'description', 'web_img_name', 'mobile_img_name', 'sales_status', 'show_status');

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        # 編輯資料
        if ($this->repository->updateData($inputs, $request)) {
            return response()->json(['status' => true, 'message' => '編輯成功']);
        }

        return response()->json(['status' => false, 'message' => '無此消息資料']);
    }
}
