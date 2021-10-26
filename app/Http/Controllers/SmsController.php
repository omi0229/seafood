<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Traits\Config as TraitsConfig;
use App\Services\SmsServices;

class SmsController extends Controller
{
    use TraitsConfig;

    protected $service_name = 'sms';

    protected $model, $request, $services;

    public function __construct(Config $model, Request $request, SmsServices $services)
    {
        $this->model = $model;
        $this->request = $request;
        $this->services = $services;
    }

    public function QueryPoints()
    {
        if (!(data_get($this->request->all(), 'sms_account') && data_get($this->request->all(), 'sms_password'))) {
            return response()->json(['status' => false, 'message' => '查詢點數失敗']);
        }

        return response()->json(['status' => true, 'message' => '查詢點數成功', 'data' => $this->services->queryPoints()]);
    }
}
