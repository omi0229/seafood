<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CookingRepository;

class CookingController extends Controller
{
    protected $repository;

    public function __construct(CookingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list($type_id, $page = null)
    {
        return response()->json($this->repository->apiList($type_id, $page));
    }
}
