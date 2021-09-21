<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait Type
{
    protected $model, $repository, $services;

    public function update(Request $request)
    {
        if (!data_get($request->all(), 'id')) {
            return response()->json(['status' => false, 'message' => '修改失敗']);
        }

        $inputs = $request->only('id', 'name');

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $info = $this->model::find($this->model::decodeSlug($inputs['id']));
        if ($info) {
            $info->update($inputs);
            return response()->json(['status' => true, 'message' => '編輯成功']);
        } else {
            return response()->json(['status' => false, 'message' => '無此分類資料']);
        }
    }
}