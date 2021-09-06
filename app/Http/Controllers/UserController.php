<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\General;
use App\Models\User;
use App\Repositories\UsersRepository;
use App\Services\UserServices;

class UserController extends Controller
{
    use General;

    protected $model, $repository, $services;

    public function __construct(User $model, UsersRepository $repository, UserServices $services)
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

        $user_id = $request->all()['id'];
        $inputs = $request->only('id', 'account', 'name', 'email', 'password', 'auth_password', 'active');

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $user = $this->model::find($this->model::decodeSlug($user_id));
        if ($user) {
            if (data_get($inputs, 'password')) {
                $inputs['password'] = Hash::make($inputs['password']);
            } else {
                unset($inputs['password']);
            }

            $user->update($inputs);
            return response()->json(['status' => true, 'message' => '編輯成功']);
        } else {
            return response()->json(['status' => false, 'message' => '無此人員資料']);
        }
    }
}
