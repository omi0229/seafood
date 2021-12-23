<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\ProductSpecifications;
use App\Repositories\ProductSpecificationRepository;
use App\Services\ProductSpecificationServices;

class ProductSpecificationController extends Controller
{
    use General;

    protected $service_name = 'product-specification';

    protected $model, $repository, $services;

    public function __construct(ProductSpecifications $model, ProductSpecificationRepository $repository, ProductSpecificationServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function list($id)
    {
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $this->repository->list($id)
        ]);
    }

    public function insert(Request $request)
    {
        $inputs = $request->only('id', 'product_id', 'name', 'original_price', 'selling_price', 'inventory', 'unit');

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

        $inputs = $request->only('id', 'product_id', 'name', 'original_price', 'selling_price', 'inventory', 'unit');

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

    public function all()
    {
        return response()->json(['status' => true, 'message' => '取得資料成功', 'data' => $this->repository->allData()]);
    }
}
