<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductServices;

class ProductController extends Controller
{
    use General;

    protected $service_name = 'product';

    protected $model, $repository, $services;

    public function __construct(Product $model, ProductRepository $repository, ProductServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }
}
