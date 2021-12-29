<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\Coupon;
use App\Repositories\CouponRepository;
use App\Services\CouponServices;

class CouponController extends Controller
{
    use General;

    protected $service_name = 'coupon';

    protected $model, $repository, $services;

    public function __construct(Coupon $model, CouponRepository $repository, CouponServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function insert(Request $request)
    {
        $inputs = $request->all();

        $inputs['coupon'] = now()->format('His') . '-' . uniqid();

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        # 新增資料
        $this->repository->insertData($inputs);

        return response()->json(['status' => true, 'message' => '新增成功']);
    }

    public function update(Request $request)
    {
        $id = data_get($request->all(), 'id');
        if (!$id) {
            return response()->json(['status' => false, 'message' => '編輯失敗']);
        }

        # 編輯資料
        if ($this->repository->updateData($request->all())) {
            return response()->json(['status' => true, 'message' => '編輯成功']);
        }

        return response()->json(['status' => false, 'message' => '編輯失敗']);
    }
}
