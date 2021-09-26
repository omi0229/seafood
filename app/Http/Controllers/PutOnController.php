<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PutOn;
use App\Repositories\PutOnRepository;
use App\Services\ProductTypesServices;
use App\Traits\General;

class PutOnController extends Controller
{
    use General;

    protected $service_name = 'put-on';

    protected $model, $repository, $services;

    public function __construct(PutOn $model, PutOnRepository $repository, ProductTypesServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }
}
