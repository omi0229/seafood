<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
