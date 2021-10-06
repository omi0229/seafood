<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\Banners;
use App\Repositories\BannersRepository;
use App\Services\BannersServices;

class BannersController extends Controller
{
    use General;

    protected $service_name = 'banners';

    protected $model, $repository, $services;

    public function __construct(Banners $model, BannersRepository $repository, BannersServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function list(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $this->repository->list($request->all())
        ]);
    }

    public function insert(Request $request)
    {
        # 驗證資料
        $validator = $this->services::authInputData($request, 'create');
        if (!$validator['status']) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        # 新增資料
        $this->repository->insertData($request);

        return response()->json(['status' => true, 'message' => '新增成功']);
    }

    public function update(Request $request)
    {
        # 驗證資料
        $validator = $this->services::authInputData($request, 'modify');
        if (!$validator['status']) {
            return response()->json(['status' => $validator['status'], 'message' => $validator['message']]);
        }

        # 編輯資料
        $this->repository->updateData($request);

        return response()->json(['status' => true, 'message' => '編輯成功']);
    }
}
