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

    /*
     * 檢查此產品是否已設定於上架管理，如有則不能刪除
     */
    public function checkDelete($id_array)
    {
        $model = app()->make(self::$model);
        $count = 0;
        $str = '';
        $data = $model::withCount('put_ons')->whereIn('id', array_map([$model, 'decodeSlug'], $id_array))->get();
        foreach ($data as $row) {
            if ($row->put_ons_count > 0) {
                $str .= $str ? ', ' . $row->title : $row->title;
            }
            $count += $row->put_ons_count;
        }

        return ['count' => $count, 'message' => $str];
    }
}
