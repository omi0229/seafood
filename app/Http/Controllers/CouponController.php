<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\Coupon;
use App\Repositories\CouponRepository;
use App\Services\CouponServices;

class CouponController extends Controller
{
    use General;

    protected $service_name = 'coupon';

    protected $model, $repository, $services;

    public function __construct(Coupon $model, CouponRepository $repository, CouponServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }
}
