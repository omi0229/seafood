<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PutOnRepository;

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
        return response()->json($this->repository->apiInfo($id));
    }
}
