<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\NewsTypesRepository;

class NewsTypeController extends Controller
{
    protected $repository;

    public function __construct(NewsTypesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list($page)
    {
        return response()->json($this->repository->list($page));
    }
}
