<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Controllers\Controller;
use App\Repositories\CouponRepository;
use App\Services\CouponServices;


class CouponController extends Controller
{
    protected $repository, $services;

    public function __construct(CouponRepository $repository, CouponServices $services)
    {
        $this->repository = $repository;
        $this->services = $services;
    }

    public function get($cart_id, $member_id = null)
    {
        $coupon = app()->make($this->repository->model());

        if ($member_id) {
            $coupon = $coupon->withCount(['coupon_records' => function ($query) use ($member_id) {
                $query->where('member_id', Member::decodeSlug($member_id));
            }]);
        } else {
            $coupon = $coupon->withCount(['coupon_records' => function ($query) use ($cart_id) {
                $query->where('cart_id', $cart_id);
            }]);
        }

        $coupon->whereHas('coupon_records', function ($query) {
            $query->whereNull(['member_id', 'cart_id']);
        })
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->orderBy('created_at', 'DESC')
        ->orderBy('id', 'DESC');

        $coupon = $coupon->first();

        if ($coupon && $coupon->coupon_records_count <= 0) {
            $data = $coupon->toArray();
            $data['id'] = $coupon->hash_id;
            return response()->json(['status' => true, 'message' => 'success', 'data' => $data]);
        }

        return response()->json(['status' => false, 'message' => 'failed']);
    }
}
