<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\NewsRepository;

class NewsController extends Controller
{
    protected $repository;

    public function __construct(NewsRepository $repository)
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