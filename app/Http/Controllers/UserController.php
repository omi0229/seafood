<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user::skip(0)->take(10)->get();
        return view('user.index', ['users' => $users]);
    }

    public function insert(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make(
            $inputs,
            [
                'account' => 'required',
                'email' => 'email',
                'password' => 'required',
                'auth_password' => 'required',
            ],
            [
                'account.required' => '請填寫帳號',
                'email.email' => '請輸入正確email',
                'password.required' => '請填寫密碼',
                'auth_password.required' => '請填寫確認密碼',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->message()]);
        }

        $inputs['password'] = Hash::make($inputs['password']);

        $this->user::create($inputs);

        return response()->json(['status' => true, 'message' => '資料新增成功']);
    }

    public function update(Request $request)
    {
        if (!data_get($request->all(), 'id')) {
            return response()->json(['status' => false, 'message' => '資料修改失敗']);
        }

        $user_id = $request->all()['id'];
        $inputs = $request->only('account', 'email', 'password', 'auth_password');

        if (data_get($inputs, 'password')) {
            $validator = Validator::make(
                $inputs,
                [
                    'account' => 'required',
                    'email' => 'required|email',
                    'password' => 'required',
                    'auth_password' => 'required',
                ],
                [
                    'account.required' => '請填寫帳號',
                    'email.email' => '請輸入正確email',
                    'password.required' => '請填寫密碼',
                    'auth_password.required' => '請填寫確認密碼',
                ]
            );

            $inputs['password'] = Hash::make($inputs['password']);
        } else {
            $validator = Validator::make(
                $inputs,
                [
                    'account' => 'required',
                    'email' => 'required|email',
                ],
                [
                    'account.required' => '請填寫帳號',
                    'email.email' => '請輸入正確email',
                ]
            );

            unset($inputs['password']);
        }

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->message()]);
        }

        $user = $this->user::find($user_id);
        if ($user) {
            $user->update($inputs);
        }

        return response()->json(['status' => true, 'message' => '資料新增成功']);
    }
}
