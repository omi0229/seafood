<?php


namespace App\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SmsCode;

class SmsCodeServices
{
    static $model = 'App\Models\SmsCode';

    protected $request, $sms_code;
    public $message = '';

    public function __construct(Request $request, SmsCode $sms_code)
    {
        $this->request = $request;
        $this->sms_code = $sms_code;
    }

    public function authCode()
    {
        $this->message = '';

        $cellphone = data_get($this->request->all(), 'cellphone');
        $sms_code = data_get($this->request->all(), 'sms_code');
        if ($cellphone && $sms_code) {
            $verification = $this->sms_code::where('cellphone', $cellphone)->first();

            if (now()->timestamp > Carbon::parse($verification->created_at)->addSeconds(env('SMS_CODE_DELAY', 60))->timestamp) {
                $this->message = '驗證碼過期，請重新發送驗證碼';
                return false;
            }

            if ($verification && $sms_code === $verification->verification_code) {
                $verification->delete();
                return true;
            } else {
                $this->message = '驗證碼錯誤';
                return false;
            }
        }

        return false;
    }
}
