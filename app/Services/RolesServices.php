<?php


namespace App\Services;

use Validator;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolesServices
{
    static $model = 'App\Models\NewsTypes';

    static function authInputData($inputs)
    {
        $model = app()->make(self::$model);

        $auth = [
            'name' => [
                'required',
                Rule::unique('roles')->ignore($model::find($model::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
        ];

        $tip = [
            'name.required' => '請填寫權限名稱',
            'name.unique' => '已有重複權限名稱',
        ];

        return Validator::make($inputs, $auth, $tip);
    }
}
