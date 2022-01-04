<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
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
        $member_id = data_get($request->all(), 'member_id') ? Member::decodeSlug(data_get($request->all(), 'member_id')) : null;
        return response()->json($this->services->search(data_get($request->all(), 'discount_codes'), $member_id));
    }
}
