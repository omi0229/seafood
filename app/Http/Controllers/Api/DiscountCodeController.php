<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DiscountCodeRepository;
use App\Services\DiscountCodeServices;


class DiscountCodeController extends Controller
{
    protected $repository, $services;

    public function __construct(DiscountCodeRepository $repository, DiscountCodeServices $services)
    {
        $this->repository = $repository;
        $this->services = $services;
    }

    public function search(Request $request)
    {
        return response()->json($this->services->search(data_get($request->all(), 'discount_codes'), data_get($request->all(), 'member_id')));
    }
}
