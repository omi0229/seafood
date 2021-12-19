<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait General
{
    public function index()
    {
        return view($this->service_name . '.index');
    }

    public function list($page, Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $this->repository->list($page, $request->all())
        ]);
    }

    public function count(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'success',
            'page_count' => (int)env('USER_PAGE_COUNT', 10),
            'count' => $this->repository->count($request->all())
        ]);
    }

    public function insert(Request $request)
    {
        $inputs = $request->all();

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $this->model::create($inputs);

        return response()->json(['status' => true, 'message' => '新增成功']);
    }

    public function delete(Request $request)
    {
        $this->model::whereIn('id', array_map([$this->model, 'decodeSlug'], (array)$request->all()))->delete();

        return response()->json(['status' => true, 'message' => '刪除成功']);
    }
}
