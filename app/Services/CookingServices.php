<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CookingServices
{
    static $model = 'App\Models\Cooking';

    static function authInputData($inputs)
    {
        $model = app()->make(self::$model);

        $auth = [
            'cooking_types_id' => 'required',
            'title' => [
                'required',
                Rule::unique('cooking')->ignore($model::find($model::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
            'start_date' => 'required',
            'end_date' => 'required',
            'youtube_id' => 'required',
        ];

        $tip = [
            'cooking_types_id.required' => '請選擇分類',
            'title.required' => '請填寫教學名稱',
            'title.unique' => '已有重複教學名稱',
            'start_date.required' => '請填寫開始時間',
            'end_date.required' => '請填寫結束時間',
            'youtube_id.required' => '請填寫youtube網址',
        ];

        return Validator::make($inputs, $auth, $tip);
    }
}
