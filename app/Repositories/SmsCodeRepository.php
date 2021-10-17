<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SmsCodeRepository extends Repository
{
    protected $request;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    public function model()
    {
        return 'App\Models\SmsCode';
    }

    public function createCode()
    {
        $code = '';
        $cellphone = data_get($this->request->all(), 'cellphone');
        $model = $this->model()::where('cellphone', $cellphone);

        if ($model->first() && now()->timestamp <= Carbon::parse($model->first()->created_at)->addSeconds(env('SMS_CODE_DELAY', 60))->timestamp) {
            $code = $model->first()->verification_code;
        } else {
            $model->delete();
            for ($n = 1; $n <= 5; $n++) {
                $code .= rand(0, 9);
            }
            $this->model->create(['cellphone' => $cellphone, 'verification_code' => $code]);
        }

        return $code;
    }
}
