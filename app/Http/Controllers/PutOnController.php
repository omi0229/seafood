<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PutOn;
use App\Repositories\PutOnRepository;
use App\Services\PutOnServices;
use App\Traits\General;

class PutOnController extends Controller
{
    use General;

    protected $service_name = 'put-on';

    protected $model, $repository, $services;

    public function __construct(PutOn $model, PutOnRepository $repository, PutOnServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function insert(Request $request)
    {
        $inputs = $request->all();

        if (!$inputs['directories_id']) {
            return response()->json(['status' => false, 'message' => '新增失敗']);
        }

        # 新增資料
        $this->repository->insertData($inputs);

        return response()->json(['status' => true, 'message' => '新增成功']);
    }

    public function update(Request $request)
    {
        $inputs = $request->all();

        # 編輯資料
        if ($this->repository->updateData($inputs)) {
            return response()->json(['status' => true, 'message' => '設定成功']);
        }

        return response()->json(['status' => false, 'message' => '設定失敗']);
    }
}
