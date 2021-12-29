<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Repositories\MembersRepository;
use App\Services\MemberServices;
use App\Services\CouponServices;

class MemberController extends Controller
{
    protected $request, $repository, $services;

    public function __construct(Request $request, MembersRepository $repository, MemberServices $services)
    {
        $this->request = $request;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function insert()
    {
        # 驗證資料
        $validator = $this->services::authInputData($this->request->all(), 'create');
        if (!$validator['status']) {
            return response()->json(['status' => false, 'message' => $validator['message']]);
        }

        $this->repository->create($this->request->all());

        return response()->json(['status' => true, 'message' => '註冊成功']);
    }

    public function update()
    {
        $inputs = $this->request->all();

        if (!data_get($inputs, 'id')) {
            return response()->json(['status' => false, 'message' => '無此會員']);
        }

        # 驗證資料
        $validator = $this->services::authInputData($inputs['form'], 'modify');
        if (!$validator['status']) {
            return response()->json(['status' => false, 'message' => $validator['message']]);
        }

        $this->repository->update(Member::decodeSlug($inputs['id']), $inputs['form']);

        return response()->json(['status' => true, 'message' => '編輯成功']);
    }

    public function changePassword()
    {
        $inputs = $this->request->all();

        # 驗證密碼
        if (!$this->services->authPassword($inputs['id'], $inputs['old_password'])) {
            return response()->json(['status' => false, 'message' => '舊密碼輸入錯誤']);
        }

        $this->repository->update(Member::decodeSlug($inputs['id']), ['password' => $inputs['password']]);

        return response()->json(['status' => true, 'message' => '密碼修改成功']);
    }

    public function forget()
    {
        $info = $this->services->forgetPassword();
        return response()->json(['status' => $info['status'], 'message' => $info['message'], 'data' => $info['data'] ?? 0]);
    }

    public function notification($member_id)
    {
        $member = $this->repository->find(Member::decodeSlug($member_id));
        if ($member) {
            $member->load(['notification' => function ($query) {
                $query->where('type', 'order_success');
                $query->where('is_load', 0);
            }]);

            $notification = $member->notification;
            if ($member->notification->count() > 0) {
                $member->notification->first()->update(['is_load' => 1]);
            }

            return response()->json(['status' => true, 'message' => '取得訊息成功', 'data' => $notification]);
        } else {
            return response()->json(['status' => false, 'message' => '取得訊息失敗']);
        }
    }

    public function getCoupon(CouponServices $coupon_services) {
        $inputs = $this->request->all();
        $coupon_id = data_get($inputs, 'coupon_id');
        $member_id = data_get($inputs, 'member_id');
        $cart_id = data_get($inputs, 'cart_id');
        if ($coupon_id && $member_id && $coupon_services->getCoupon($coupon_id, $member_id, $cart_id)) {
            return response()->json(['status' => true, 'message' => '領取成功']);
        }

        return response()->json(['status' => false, 'message' => '領取失敗']);
    }

    public function couponList($member_id, $used = null)
    {
        return response()->json(['status' => true, 'message' => '取得列表成功', 'data' => (new CouponServices)->couponList($member_id, $used, $this->request->all())]);
    }

    public function couponUse()
    {
        $inputs = $this->request->all();
        $member_id = data_get($inputs, 'member_id');
        if ($member_id) {
            return response()->json(['status' => true, 'message' => '取得列表成功', 'data' => (new CouponServices)->couponList($member_id, 'false', $inputs)]);
        }

        return response()->json(['status' => false, 'message' => '取得列表失敗']);
    }
}
