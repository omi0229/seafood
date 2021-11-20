<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\Freight;
use App\Repositories\FreightRepository;
use App\Services\FreightServices;

class FreightController extends Controller
{
    use General;

    protected $service_name = 'freight';

    protected $model, $repository, $services;

    public function __construct(Freight $model, FreightRepository $repository, FreightServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function insert(Request $request)
    {
        $inputs = $request->all();

        # 驗證運費類型資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $this->repository->insertData($inputs);

        return response()->json(['status' => true, 'message' => '新增成功']);
    }

    public function update(Request $request)
    {
        if (!data_get($request->all(), 'id')) {
            return response()->json(['status' => false, 'message' => '編輯失敗']);
        }

        $id = $request->all()['id'];
        $inputs = $request->only('id', 'parents_id', 'floor', 'title', 'start_date', 'end_date', 'default', 'sort', 'status', 'start_total', 'end_total', 'freight');

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        unset($inputs['id']);
        if (data_get($inputs, 'parents_id')) {
            $inputs['parents_id'] = $this->model::decodeSlug($inputs['parents_id']);
        }

        if (data_get($inputs, 'end_date')) {
            $inputs['end_date'] = substr($inputs['end_date'], 0, 10) . ' 23:59:59';
        }

        # 編輯資料
        if ($this->repository->update($this->model::decodeSlug($id), $inputs)) {
            return response()->json(['status' => true, 'message' => '編輯成功']);
        }

        return response()->json(['status' => false, 'message' => '無此類型資料']);
    }

    public function delete(Request $request)
    {
        $id_array = array_map([$this->model, 'decodeSlug'], (array)$request->all());
        $object = $this->model::with('children')->whereIn('id', $id_array)->get();

        $delete_info = $this->services->authDelete($object);
        if ($delete_info['count'] > 0) {
            return response()->json(['status' => false, 'message' => '以下類型尚有子項目，不可刪除。 ' . $delete_info['string']]);
        }

        $this->model::whereIn('id', $id_array)->delete();

        return response()->json(['status' => true, 'message' => '刪除成功']);
    }

    public function parents($parents_id)
    {
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $this->repository->list('all', ['parents_id' => $parents_id]),
        ]);
    }
}
