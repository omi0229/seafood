<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Services\SmsServices;

class SmsCodeRepository extends Repository
{
    protected $request, $services;

    public function __construct(Request $request, SmsServices $services)
    {
        parent::__construct();
        $this->request = $request;
        $this->services = $services;
    }

    public function model()
    {
        return 'App\Models\SmsCode';
    }

    public function createCode()
    {
        $code = '';
        $cellphone = data_get($this->request->all(), 'cellphone');
        if ($cellphone) {
            $model = $this->model()::where('cellphone', $cellphone)->orderBy('created_at', 'DESC');

            $seconds = Carbon::parse($model->first()->created_at)->addSeconds(env('SMS_CODE_DELAY', 60))->timestamp - now()->timestamp;
            if ($model->first() && $seconds > 0) {
                return ['status' => false, 'message' => '發送間隔過短', 'data' => $seconds];
            }

            (new $this->model())->where('cellphone', $cellphone)->delete();
            for ($n = 1; $n <= 5; $n++) {
                $code .= rand(0, 9);
            }

            # 發送簡訊
            $result = $this->services->send([$cellphone], $code);

            if ($result['status'] == 0) {
                $this->model->create(['cellphone' => $cellphone, 'verification_code' => $code]);
                return ['status' => true, 'message' => $code];
            }
        }

        return ['status' => false, 'message' => '發送失敗'];
    }
}
