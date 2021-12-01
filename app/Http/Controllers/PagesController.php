<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\Pages;
use App\Repositories\PagesRepository;

class PagesController extends Controller
{
    use General;

    protected $service_name = 'pages';

    protected $model, $repository;

    public function __construct(Pages $model, PagesRepository $repository)
    {
        $this->model = $model;
        $this->repository = $repository;
    }

    public function list(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $this->repository->all()
        ]);
    }

    public function update(Request $request)
    {
        $inputs = $request->all();
        if (!data_get($inputs, 'type')) {
            return response()->json(['status' => false, 'message' => '頁面類型錯誤']);
        }

        return response()->json([
            'status' => true,
            'message' => '編輯完成',
            'data' => $this->model->where('type', $inputs['type'])->update(['content' => $inputs['content']])
        ]);
    }
}
