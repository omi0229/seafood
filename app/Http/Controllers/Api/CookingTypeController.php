<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Repositories\CookingTypesRepository;

class CookingTypeController extends Controller
{
    protected $repository;

    public function __construct(CookingTypesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list($page)
    {
        return response()->json(Cache::remember('list', Carbon::now()->addMinutes(10), function () use ($page) {
            return $this->repository->list($page);
        }));
    }
}
