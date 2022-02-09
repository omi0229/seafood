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
                $str .= $str ? ', ' . $row->name : $row->name;
            }
            $count += $row->put_ons_count;
        }

        return ['count' => $count, 'message' => $str];
    }
}
