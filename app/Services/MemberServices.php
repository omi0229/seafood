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
}
