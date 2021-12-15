<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;

class DiscountCodeController extends Controller
{
    use General;

    protected $service_name = 'discount-code';

//    protected $model, $repository, $services;
//
//    public function __construct(Freight $model, FreightRepository $repository, FreightServices $services)
//    {
//        $this->model = $model;
//        $this->repository = $repository;
//        $this->services = $services;
//    }
}
