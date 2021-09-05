<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;

class UserServices
{
    static function authInputData(Request $request)
    {
        if (data_get($request->all(), 'password')) {
            $request->validate([
                'account' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'auth_password' => 'required',
            ], [
                'account.required' => '請填寫帳號',
                'email.email' => '請輸入正確email',
                'password.required' => '請填寫密碼',
                'auth_password.required' => '請填寫確認密碼',
            ]);
        } else {
            $request->validate([
                'account' => 'required',
                'email' => 'required|email',
            ], [
                'account.required' => '請填寫帳號',
                'email.email' => '請輸入正確email',
            ]);
        }
    }
}