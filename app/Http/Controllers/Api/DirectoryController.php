<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Repositories\DirectoryRepository;

class DirectoryController extends Controller
{
    protected $repository;

    public function __construct(DirectoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list($page)
    {
        return response()->json(Cache::remember('directory_list', Carbon::now()->addMinutes(10), function () use ($page) {
            return $this->repository->apiList($page);
        }));
    }
}
