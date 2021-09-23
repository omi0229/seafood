<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductServices
{
    static $model = 'App\Models\Products';

    static function authInputData(&$inputs)
    {
        $model = app()->make(self::$model);

        $auth = [
            'product_types_id' => 'required',
            'title' => [
                'required',
                Rule::unique('products')->ignore($model::find($model::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
        ];

        $tip = [
            'news_types_id.required' => '請選擇分類',
            'title.required' => '請填寫消息名稱',
            'title.unique' => '已有重複消息名稱',
        ];

        return Validator::make($inputs, $auth, $tip);
    }
}
