<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NewsServices
{
    static $model = 'App\Models\News';

    static function authInputData(&$inputs)
    {
        $model = app()->make(self::$model);

        $auth = [
            'news_types_id' => 'required',
            'title' => [
                'required',
                Rule::unique('news')->ignore($model::find($model::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $tip = [
            'news_types_id.required' => '請選擇分類',
            'title.required' => '請填寫消息名稱',
            'title.unique' => '已有重複消息名稱',
            'start_date.required' => '請填寫開始時間',
            'end_date.required' => '請填寫結束時間',
        ];

        return Validator::make($inputs, $auth, $tip);
    }
}
