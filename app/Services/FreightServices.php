<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FreightServices
{
    static $model = 'App\Models\Freight';

    static function authInputData($inputs)
    {
        $model = app()->make(self::$model);

        $floor = data_get($inputs, 'floor') ? $inputs['floor'] : 1;

        switch ($floor) {
            case 2:
                $auth = [
                    'title' => ['required', Rule::unique('freights')->ignore($model::find($model::decodeSlug($inputs['id'])))->where('parents_id', $model::decodeSlug($inputs['parents_id']))->where('floor', $floor)->whereNull('deleted_at')],
                    'sort' => ['required', Rule::unique('freights')->ignore($model::find($model::decodeSlug($inputs['id'])))->where('parents_id', $model::decodeSlug($inputs['parents_id']))->where('floor', $floor)->whereNull('deleted_at')],
                    'status' => 'required',
                ];
                break;
            case 3:
                $auth = [
                    'start_total' =>  'required',
                    'end_total' =>  'required',
                    'freight' =>  'required',
                ];
                break;
            default:
                $auth = [
                    'title' => ['required', Rule::unique('freights')->ignore($model::find($model::decodeSlug($inputs['id'])))->where('floor', $floor)->whereNull('deleted_at')],
                    'start_date' => 'required',
                    'end_date' => 'required',
                    'default' => [Rule::unique('freights')->ignore($model::find($model::decodeSlug($inputs['id'])))->where('default', 1)->whereNull('deleted_at')],
                ];
                break;
        }

        $tip = [
            'title.required' => '請填寫類型名稱',
            'title.unique' => '已有重複類型名稱',
            'start_date.required' => '請填寫開始時間',
            'end_date.required' => '請填寫結束時間',
            'sort.required' => '請填寫排序數字',
            'sort.unique' => '排序數字不得重複',
            'status.required' => '請填寫顯示狀態',
            'default.unique' => '只能設定一筆預設值',
            'start_total.required' => '請填寫金額起始範圍',
            'end_total.required' => '請填寫金額結束範圍',
            'freight.required' => '請填寫運費',
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
