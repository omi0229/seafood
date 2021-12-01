<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PagesRepository;

class PagesController extends Controller
{
    protected $repository;

    public function __construct(PagesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function info($type)
    {
        return response()->json($this->repository->apiInfo($type));
    }
}
