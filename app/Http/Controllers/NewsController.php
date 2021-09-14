<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\News;
use App\Models\NewsTypes;
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
//        dump(storage_path('news'));
//        dump($request->file('web_img'));
//        dump($request->file('mobile_img'));
//        dd($inputs);

        $inputs = $request->only('id', 'news_types_id', 'title', 'start_date', 'end_date', 'href', 'description', 'target', 'keywords', 'status', 'web_img_name', 'mobile_img_name');

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        unset($inputs['id']);
        $inputs['news_types_id'] = NewsTypes::decodeSlug($inputs['news_types_id']);

        if ($request->hasFile('web_img')) {
            $inputs['web_img'] = 'news/' . $request->file('web_img')->getClientOriginalName();
            $request->file('web_img')->store('news');
        }

        if ($request->hasFile('mobile_img')) {
            $inputs['mobile_img'] = 'news/' . $request->file('mobile_img')->getClientOriginalName();
            $request->file('web_img')->store('news');
        }

        $this->model::create($inputs);

        return response()->json(['status' => true, 'message' => '新增成功']);
    }
}
