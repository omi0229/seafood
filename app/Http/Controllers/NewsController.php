<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\News;
use App\Repositories\NewsRepository;
use App\Services\NewsServices;

class NewsController extends Controller
{
    use General;

    protected $service_name = 'news';

    protected $model, $repository, $services;

    public function __construct(News $model, NewsRepository $repository, NewsServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function insert(Request $request)
    {
        $inputs = $request->only('id', 'news_types_id', 'title', 'start_date', 'end_date', 'href', 'description', 'target', 'keywords', 'carousel', 'status', 'web_img_name', 'mobile_img_name');

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        # 新增資料
        $this->repository->insertData($inputs, $request);

        return response()->json(['status' => true, 'message' => '新增成功']);
    }

    public function update(Request $request)
    {
        if (!data_get($request->all(), 'id')) {
            return response()->json(['status' => false, 'message' => '修改失敗']);
        }

        $inputs = $request->only('id', 'news_types_id', 'title', 'start_date', 'end_date', 'href', 'description', 'target', 'keywords', 'carousel', 'status', 'web_img_name', 'mobile_img_name');

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        # 編輯資料
        if ($this->repository->updateData($inputs, $request)) {
            return response()->json(['status' => true, 'message' => '編輯成功']);
        }

        return response()->json(['status' => false, 'message' => '無此消息資料']);
    }
}
