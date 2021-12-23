<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponServices
{
    static $model = 'App\Models\Coupon';

    static function authInputData($inputs)
    {
        $model = app()->make(self::$model);

        $auth = [
            'records' => 'required|numeric',
            'title' => [
                'required',
                Rule::unique('coupons')->ignore($model::find($model::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
            'full_amount' => 'required|numeric',
            'discount' => 'required|numeric',
            'coupon' => [
                'required',
                'string',
                Rule::unique('coupons')->ignore($model::find($model::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];

        $tip = [
            'records.required' => '請填寫優惠筆數',
            'records.numeric' => '優惠筆數請輸入數字',
            'title.required' => '請輸入標題',
            'title.unique' => '已有重複標題名稱',
            'full_amount.required' => '請輸入結帳金額',
            'full_amount.numeric' => '結帳金額請輸入數字',
            'discount.required' => '請輸入優惠金額',
            'discount.numeric' => '優惠金額請輸入數字',
            'coupon.required' => '請輸入優惠劵名稱',
            'coupon.string' => '優惠劵類型需為字串',
            'coupon.unique' => '已有重複優惠劵名稱',
            'start_date.required' => '請選擇開始日期',
            'start_date.date' => '開始日期類型需為日期格式',
            'end_date.required' => '請選擇結束日期',
            'end_date.date' => '結束日期類型需為日期格式',
        ];

        return Validator::make($inputs, $auth, $tip);
    }

    public function search($fixed_name)
    {
        if (!$fixed_name) {
            return ['status' => false, 'message' => '無此優惠代碼'];
        }

        $data = app()->make(self::$model)
            ->with(['discount_records'])
            ->where('start_date', '<=', now()->format('Y-m-d H:i:s'))
            ->where('end_date', '>=', now()->format('Y-m-d H:i:s'))
            ->where('records', '>', 0);

        $info = $data->firstWhere('fixed_name', $fixed_name);

        if ($info) {

            if ($info->discount_records->count() >= $info->records) {
                return ['status' => false, 'message' => 'error'];
            }

            return ['status' => true, 'message' => 'success', 'data' => $info];
        }

        return ['status' => false, 'message' => '無此優惠代碼'];
    }
}
