<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DirectoryRepository;

class DirectoryController extends Controller
{
    protected $repository;

    public function __construct(DirectoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        return response()->json($this->repository->list(1));
    }
}
