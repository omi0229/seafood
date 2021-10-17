<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SmsCodeRepository;
use App\Services\SmsCodeServices;

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
            return response()->json(['status' => true, 'message' => $sms_code_repository->createCode()]);
        }

        return response()->json(['status' => false, 'message' => '產生簡訊驗證碼失敗']);
    }

    public function authSmsCode(SmsCodeServices $sms_code_services)
    {
        if ($sms_code_services->authCode()) {
            return response()->json(['status' => true, 'message' => '驗證碼正確']);
        }

        return response()->json(['status' => false, 'message' => $sms_code_services->message]);
    }
}
