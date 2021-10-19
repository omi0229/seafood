<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberServices
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    static $model = 'App\Models\Member';

    static function authInputData($request, $type = 'create')
    {
        $inputs = $request->all();

        $auth = [
            'cellphone' => 'required',
            'password' => 'required',
            'name' => 'required',
        ];

        $tip = [
            'cellphone.required' => '請填寫手機號碼',
            'password.required' => '請填寫密碼',
            'name.required' => '請填寫真實名字',
        ];

        $validator = Validator::make($inputs, $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()->first()];
        }

        if ($type === 'create' && !self::authCellphone($inputs['cellphone'])) {
            return ['status' => false, 'message' => '已有重複手機號碼資料'];
        }

        return ['status' => true ];
    }

    static function authCellphone($cellphone)
    {
        $model = app()->make(self::$model)->where('cellphone', $cellphone);
        if ($model->count() > 0) {
            return false;
        }

        return true;
    }

    public function authLogin()
    {
        $credentials = $this->request->only('cellphone', 'password');

        $auth = [
            'cellphone' => 'required|string',
            'password' => 'required|string',
        ];

        $tip = [
            'cellphone.required' => '請輸入帳號 (手機號碼)',
            'password.required' => '請輸入密碼',
        ];

        $validator = Validator::make($credentials, $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()->first()];
        }

        $member = app()->make(self::$model)::where('cellphone', $credentials['cellphone'])->where('active', 1)->first();
        $validCredentials = \Hash::check($credentials['password'], optional($member)->getAuthPassword());

        if (!$validCredentials) {
            return ['status' => false, 'message' => '帳號或密碼錯誤'];
        }

        return ['status' => true, 'message' => '登入成功', 'member' => $member];
    }
}
