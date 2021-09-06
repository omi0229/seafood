<?php


namespace App\Services;

use Validator;
use App\Models\Roles;
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
                Rule::unique('roles')->ignore(Roles::find(Roles::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
        ];

        $tip = [
            'name.required' => '請填寫帳號',
            'name.unique' => '已有重複帳號',
        ];

        return Validator::make($inputs, $auth, $tip);
    }
}
