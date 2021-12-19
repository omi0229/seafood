<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\DiscountCode;
use App\Models\DiscountRecord;
use App\Repositories\DiscountCodeRepository;
use App\Services\DiscountCodeServices;

class DiscountCodeController extends Controller
{
    use General;

    protected $service_name = 'discount-code';

    protected $model, $repository, $services;

    public function __construct(DiscountCode $model, DiscountCodeRepository $repository, DiscountCodeServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function insert(Request $request)
    {
        $inputs = $request->all();

        $inputs['fixed_name'] = data_get($inputs, 'is_fixed') && (int)data_get($inputs, 'is_fixed') === 1 ? $inputs['fixed_name'] : uniqid();

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $this->model::create($inputs);

        return response()->json(['status' => true, 'message' => '新增成功']);
    }

    public function update(Request $request)
    {
        $id = data_get($request->all(), 'id');
        $records = data_get($request->all(), 'records');
        if (!($id && $records)) {
            return response()->json(['status' => false, 'message' => '編輯失敗']);
        }

        $item = $this->repository->find($this->model::decodeSlug($id));
        if ($item && is_numeric($records) && $records >= 0) {
            $item->records += $records;
            $item->save();
            return response()->json(['status' => true, 'message' => '編輯成功']);
        }

        return response()->json(['status' => false, 'message' => '編輯失敗']);
    }

    public function recordDelete(Request $request, DiscountRecord $discount_record)
    {
        $discount_record->whereIn('id', array_map([$discount_record, 'decodeSlug'], (array)$request->all()))->delete();

        return response()->json(['status' => true, 'message' => '刪除成功']);
    }
}
