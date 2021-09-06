<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Roles;
use App\Repositories\RolesRepository;
use App\Services\RolesServices;
use App\Traits\General;

class RoleController extends Controller
{
    use General;

    protected $model, $repository, $services;

    public function __construct(Roles $model, RolesRepository $repository, RolesServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function update(Request $request)
    {
        if (!data_get($request->all(), 'id')) {
            return response()->json(['status' => false, 'message' => '修改失敗']);
        }

        $id = $request->all()['id'];
        $inputs = $request->only('id', 'name');

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $info = $this->model::find($this->model::decodeSlug($id));
        if ($info) {
            $info->update($inputs);
            return response()->json(['status' => true, 'message' => '編輯成功']);
        } else {
            return response()->json(['status' => false, 'message' => '無此人員資料']);
        }
    }
}
