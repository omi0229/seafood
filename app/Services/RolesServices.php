<?php


namespace App\Services;

use Validator;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolesServices
{
    static $service_name = 'role';

    static function authInputData($inputs)
    {
        $auth = [
            'name' => [
                'required',
                Rule::unique('roles')->ignore(Role::find(Role::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
        ];

        $tip = [
            'name.required' => '請填寫權限名稱',
            'name.unique' => '已有重複權限名稱',
        ];

        return Validator::make($inputs, $auth, $tip);
    }
}
