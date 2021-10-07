<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BannersRepository;

class BannersController extends Controller
{
    protected $repository;

    public function __construct(BannersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return response()->json($this->repository->apiList());
    }
}
