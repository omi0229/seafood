<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Repositories\UsersRepository;
use App\Services\UserServices;

class UserController extends Controller
{
    protected $user, $repository;

    public function __construct(User $user, UsersRepository $users_repository)
    {
        $this->user = $user;
        $this->users_repository = $users_repository;
    }

    public function index()
    {
        return view('user.index');
    }

    public function list($page, Request $request)
    {
        $params = $request->all();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $this->users_repository->list($page, $params),
        ]);
    }

    public function insert(Request $request)
    {
        $inputs = $request->all();

        try {
            # 驗證資料
            UserServices::authInputData($request);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => '驗證失敗']);
        }

        $inputs['password'] = Hash::make($inputs['password']);

        $this->user::create($inputs);

        return response()->json(['status' => true, 'message' => '新增成功']);
    }

    public function update(Request $request)
    {
        if (!data_get($request->all(), 'id')) {
            return response()->json(['status' => false, 'message' => '修改失敗']);
        }

        $user_id = $request->all()['id'];
        $inputs = $request->only('account', 'email', 'password', 'auth_password');

        try {
            # 驗證資料
            UserServices::authInputData($request);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => '驗證失敗']);
        }

        $user = $this->user::find($this->user::decodeSlug($user_id));
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

    public function delete(Request $request){

        $this->user::whereIn('id', array_map([User::class, 'decodeSlug'], (array) $request->all()))
            ->delete();

        return response()->json(['status' => true, 'message' => '刪除成功']);
    }
}
