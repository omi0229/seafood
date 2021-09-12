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
        $inputs = $request->all();
        dump($request->file('web_img')->isValid());
        dump($request->file('mobile_img')->isValid());
        dd($inputs);
        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $this->model::create($inputs);

        return response()->json(['status' => true, 'message' => '新增成功']);
    }
}
