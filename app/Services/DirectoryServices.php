<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DirectoryServices
{
    static $table = 'directories';

    static $model = 'App\Models\Directory';

    static function authInputData($inputs)
    {
        $model = app()->make(self::$model);

        $auth = [
            'name' => [
                'required',
                Rule::unique(self::$table)->ignore($model::where('name', $inputs['name'])->get())->whereNull('deleted_at')
            ],
        ];

        $tip = [
            'name.required' => '請填寫分類名稱',
            'name.unique' => '已有重複分類名稱',
        ];

        return Validator::make($inputs, $auth, $tip);
    }
}
