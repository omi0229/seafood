<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductTypes;
use App\Repositories\ProductTypesRepository;
use App\Services\ProductTypesServices;
use App\Traits\General;
use App\Traits\Type;

class ProductTypeController extends Controller
{
    use General, Type;

    protected $service_name = 'product-types';

    public function __construct(ProductTypes $model, ProductTypesRepository $repository, ProductTypesServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }
}
