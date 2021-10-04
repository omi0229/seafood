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

    public function list($type_id, $page = null)
    {
        return response()->json($this->repository->apiData($type_id, $page));
    }

    public function info($id)
    {
        return response()->json($this->repository->apiInfo($id));
    }
}
