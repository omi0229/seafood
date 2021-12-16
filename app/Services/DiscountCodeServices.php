<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DiscountCodeServices
{
    static $model = 'App\Models\DiscountCode';

    static function authInputData($inputs)
    {
        $model = app()->make(self::$model);

        $auth = [
            'records' => 'required|numeric',
            'title' => [
                'required',
                Rule::unique('discount_codes')->ignore($model::find($model::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
            'full_amount' => 'required|numeric',
            'discount' => 'required|numeric',
            'is_fixed' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];

        if ($inputs['is_fixed'] == 1) {
            $auth['fixed_name'] = 'required|string';
        }

        $tip = [
            'records.required' => '請填寫優惠筆數',
            'records.numeric' => '優惠筆數請輸入數字',
            'title.required' => '請輸入標題',
            'title.unique' => '已有重複標題名稱',
            'full_amount.required' => '請輸入結帳金額',
            'full_amount.numeric' => '結帳金額請輸入數字',
            'discount.required' => '請輸入優惠金額',
            'discount.numeric' => '優惠金額請輸入數字',
            'is_fixed.required' => '請選擇固定名稱類型',
            'is_fixed.numeric' => '固定名稱類型需為數字',
            'fixed_name.required' => '請選擇固定名稱',
            'fixed_name.string' => '固定名稱類型需為字串',
            'start_date.required' => '請選擇開始日期',
            'start_date.date' => '開始日期類型需為日期格式',
            'end_date.required' => '請選擇結束日期',
            'end_date.date' => '結束日期類型需為日期格式',
        ];

        return Validator::make($inputs, $auth, $tip);
    }

    public function authDelete($array)
    {
        $count = 0;
        $string = '';
        foreach ($array as $row) {
            if($row->children->count() > 0) {
                $count += $row->children->count();
                $string .= !$string ? $row->title : '、' . $row->title;
            }
        }

        return ['count' => $count, 'string' => $string];
    }

    public function getFeightList()
    {
        $model = app()->make(self::$model);
        $now = now()->format('Y-m-d h:i:s');
        $array = $model::with('children.children')->where('floor', 1)->orderBy('start_date', 'DESC')->get()->toArray();
        $list = [];
        foreach ($array as $row) {
            # 第一層 若沒有設定基本值或現在時間未在範圍內 則不採用此運費規則
            if(!($row['default'] === 1 || ($row['default'] === 0 && ($now > $row['start_date'] && $now <= $row['end_date'])))){
                continue;
            }

            $floor2_array = collect($row['children'])->where('status', 1)->sortBy('sort')->toArray();
            # 第二層迴圈
            foreach ($floor2_array as $floor2) {

                $floor3_array = collect($floor2['children'])->sortBy('start_total')->toArray();
                foreach ($floor3_array as $floor3) {
                    $data = [
                        'id' => $model->find($floor3['id'])->hash_id ?? null,
                        'floor1_type' => $row['title'],
                        'floor2_type' => $floor2['title'],
                        'start_total' => $floor3['start_total'],
                        'end_total' => $floor3['end_total'],
                        'freight' => $floor3['freight'],
                    ];
                    array_push($list, $data);
                }

            }
        }

        return $list;
    }
}
