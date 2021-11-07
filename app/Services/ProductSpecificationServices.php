<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductSpecificationServices
{
    static $model = 'App\Models\ProductSpecifications';

    static $product_model = 'App\Models\Products';

    static function authInputData(&$inputs)
    {
        $model = app()->make(self::$model);
        $product_model = app()->make(self::$product_model);

        $auth = [
            'product_id' => 'required',
            'name' => [
                'required',
                Rule::unique('product_specifications')->ignore($model::find($model::decodeSlug($inputs['id'])))->where('product_id', $product_model::decodeSlug($inputs['product_id']))->whereNull('deleted_at')
            ],
            'original_price' => 'required',
            'selling_price' => 'required',
            'inventory' => 'required',
            'unit' => 'required',
        ];

        $tip = [
            'product_id.required' => '未關聯到指定產品',
            'name.required' => '請填寫規格名稱',
            'name.unique' => '已有重複規格名稱',
            'original_price.required' => '請填寫原價',
            'selling_price.required' => '請填寫售價',
            'inventory.required' => '請填寫庫存',
            'unit.required' => '請填寫單位',
        ];

        return Validator::make($inputs, $auth, $tip);
    }
}
