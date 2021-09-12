<?php


namespace App\Services;

use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserServices
{
    static $model = 'App\Models\User';

    static function authInputData(&$inputs)
    {
        $model = app()->make(self::$model);

        $auth = [
            'account' => [
                'required',
                Rule::unique('users')->ignore($model::find($model::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
            'name' => 'required',
            'email' => 'required|email',
        ];

        $tip = [
            'account.required' => '請填寫帳號',
            'account.unique' => '已有重複帳號',
            'name.required' => '請填寫姓名',
            'email.email' => '請輸入正確email',
        ];

        if (data_get($inputs, 'password')) {
            $auth['password'] =  'required';
            $auth['auth_password'] =  'required';
            $tip['password.required'] =  '請填寫密碼';
            $tip['auth_password.required'] =  '請填寫確認密碼';
        }

        return Validator::make($inputs, $auth, $tip);
    }
}
