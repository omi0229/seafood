<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Directory;
use App\Repositories\DirectoryRepository;
use App\Services\DirectoryServices;
use App\Traits\General;
use App\Traits\Type;

class DirectoryController extends Controller
{
    use General, Type;

    protected $service_name = 'directory';

    public function __construct(Directory $model, DirectoryRepository $repository, DirectoryServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function checkDelete(Request $request)
    {
        return response()->json($this->services->checkDelete((array)$request->all()['data']));
    }
}
