<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
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
        $inputs = $this->request->all();

        if (isset($inputs['cellphone']) && isset($inputs['name'])) {

            $model = Member::where('cellphone', $inputs['cellphone'])->where('name', $inputs['name']);
            if ($model->count() > 0) {
                return response()->json(['status' => true, 'message' => '已寄發簡訊']);
            }

            return response()->json(['status' => false, 'message' => '無此會員資料']);
        }

        return response()->json(['status' => false, 'message' => '輸入資料錯誤']);
    }
}
