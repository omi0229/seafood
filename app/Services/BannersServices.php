<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BannersServices
{
    static $model = 'App\Models\Banners';

    static function authInputData($request, $type = 'create')
    {
        if ($type === 'modify' && !data_get($request->all(), 'id')) {
            return ['status' => false, 'message' => '無此大圖資料'];
        }

        $inputs = $request->only('web_img_name', 'mobile_img_name');

        $auth = [
            'web_img_name' => 'required',
            'mobile_img_name' => 'required',
        ];

        $tip = [
            'web_img_name.required' => '請選擇一張電腦版大圖',
            'mobile_img_name.required' => '請選擇一張手機版大圖',
        ];

        $validator = Validator::make($inputs, $auth, $tip);
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()->first()];
        }

        return ['status' => true];
    }
}
