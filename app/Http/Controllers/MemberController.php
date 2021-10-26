<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\Member;
use App\Repositories\MembersRepository;
use App\Services\MemberServices;

class MemberController extends Controller
{
    use General;

    protected $service_name = 'member';

    protected $model, $repository, $services;

    public function __construct(Member $model, MembersRepository $repository, MemberServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function insert(Request $request)
    {
        $inputs = $request->all();

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if (!$validator['status']) {
            return response()->json(['status' => false, 'message' => $validator['message']]);
        }

        $this->model::create($inputs);

        return response()->json(['status' => true, 'message' => '新增成功']);
    }

    public function update(Request $request)
    {
        $inputs = $request->all();

        # 驗證資料
        $validator = $this->services::authInputData($inputs, 'modify');
        if (!$validator['status']) {
            return response()->json(['status' => $validator['status'], 'message' => $validator['message']]);
        }

        $id = data_get($inputs, 'id');
        unset($inputs['id']);

        if (!data_get($inputs, 'password')) {
            unset($inputs['password']);
        }

        # 編輯資料
        $this->repository->update(Member::decodeSlug($id), $inputs);

        return response()->json(['status' => true, 'message' => '編輯成功']);
    }

    public function export()
    {
        return $this->services->exportMembers();
    }
}
