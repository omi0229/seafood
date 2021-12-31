<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SmsCodeRepository;
use App\Services\SmsCodeServices;
use App\Services\MemberServices;
use App\Services\CouponServices;
use App\Http\Resources\MemberResource;

class AuthController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function setSmsCode(SmsCodeRepository $sms_code_repository)
    {
        if (data_get($this->request->all(), 'cellphone')) {

            $info = $sms_code_repository->createCode();

            return response()->json(['status' => $info['status'], 'message' => $info['message'], 'data' => $info['data'] ?? '']);
        }

        return response()->json(['status' => false, 'message' => '沒有設定手機']);
    }

    public function authSmsCode(SmsCodeServices $sms_code_services)
    {
        if ($sms_code_services->authCode()) {
            return response()->json(['status' => true, 'message' => '驗證碼正確']);
        }

        return response()->json(['status' => false, 'message' => $sms_code_services->message]);
    }

    public function login(MemberServices $member_services, CouponServices $coupon_services)
    {
        # 驗證帳密
        $validator = $member_services->authLogin();
        if (!$validator['status']) {
            return response()->json(['status' => $validator['status'], 'message' => $validator['message']]);
        }

        # 釋放所有過期的優惠劵
        $coupon_services->couponRecordAuth($validator['member']->id);

        return response()->json(['status' => true, 'message' => '登入成功', 'data' => new MemberResource($validator['member'])]);
    }
}
