<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\EventServiceProvider;
use Illuminate\Http\Request;
use App\Repositories\PutOnRepository;
use App\Services\EventServices;

class PutOnController extends Controller
{
    protected $repository;

    public function __construct(PutOnRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list($type_id, $page = null, Request $request)
    {
        return response()->json($this->repository->apiList($type_id, $page, $request->all()));
    }

    public function info($id)
    {
        # 增加一筆此產品瀏覽人數
        $event = new EventServices;
        $event->addProductVisits($id);

        return response()->json($this->repository->apiInfo($id));
    }

    public function putOnRandom($id, $count = 4, Request $request)
    {
        return response()->json($this->repository->relationRandomProduct($id, $count, $request->all()));
    }
}
