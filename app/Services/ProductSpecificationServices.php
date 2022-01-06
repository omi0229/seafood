<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\UserServices;

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

    # 計算顧客訂單加減後的的庫存
    static function inventoryCalculation($list)
    {
        if (is_array($list)) {
            $model = app()->make(self::$model);
            foreach ($list as $row) {
                $item = $model::with(['product'])->find($model::decodeSlug($row['specifications_id']));
                if ($item) {
                    $item->inventory -= $row['count'];
                    $item->save();

                    $item->refresh();
                    # 如庫存為0則發送推播通知
                    if ($item->inventory === 0) {
                        # line notify 推播
                        $userServices = new UserServices;
                        $userServices->pushAdminNotify('【產品：' . $item->product->title . ' 規格：' . $item->name . ' 】請檢查庫存');
                    }
                }
            }
        }

        return true;
    }
}
