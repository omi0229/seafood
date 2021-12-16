<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\DiscountCode;
use App\Repositories\DiscountCodeRepository;
use App\Services\DiscountCodeServices;

class DiscountCodeController extends Controller
{
    use General;

    protected $service_name = 'discount-code';

    protected $model, $repository, $services;

    public function __construct(DiscountCode $model, DiscountCodeRepository $repository, DiscountCodeServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }
}
