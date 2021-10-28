<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\ForgetPasswordLog;
use App\Repositories\MembersRepository;
use App\Services\MemberServices;

class MemberController extends Controller
{
    protected $request, $repository, $services;

    public function __construct(Request $request, MembersRepository $repository, MemberServices $services)
    {
        $this->request = $request;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function insert()
    {
        # 驗證資料
        $validator = $this->services::authInputData($this->request->all(), 'create');
        if (!$validator['status']) {
            return response()->json(['status' => false, 'message' => $validator['message']]);
        }

        $this->repository->create($this->request->all());

        return response()->json(['status' => true, 'message' => '註冊成功']);
    }

    public function update()
    {
        $inputs = $this->request->all();

        if (!data_get($inputs, 'id')) {
            return response()->json(['status' => false, 'message' => '無此會員']);
        }

        # 驗證資料
        $validator = $this->services::authInputData($inputs['form'], 'modify');
        if (!$validator['status']) {
            return response()->json(['status' => false, 'message' => $validator['message']]);
        }

        $this->repository->update(Member::decodeSlug($inputs['id']), $inputs['form']);

        return response()->json(['status' => true, 'message' => '編輯成功']);
    }

    public function changePassword()
    {
        $inputs = $this->request->all();

        # 驗證密碼
        if (!$this->services->authPassword($inputs['id'], $inputs['old_password'])) {
            return response()->json(['status' => false, 'message' => '舊密碼輸入錯誤']);
        }

        $this->repository->update(Member::decodeSlug($inputs['id']), ['password' => $inputs['password']]);

        return response()->json(['status' => true, 'message' => '密碼修改成功']);
    }

    public function forget()
    {
        $info = $this->services->forgetPassword();
        return response()->json(['status' => $info['status'], 'message' => $info['message'], 'data' => $info['data'] ?? 0]);
    }
}
