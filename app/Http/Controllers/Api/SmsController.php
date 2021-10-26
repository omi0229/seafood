<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Services\SmsServices;

class SmsController extends Controller
{
    protected $model, $request, $services;

    public function __construct(Config $model, Request $request, SmsServices $services)
    {
        $this->model = $model;
        $this->request = $request;
        $this->services = $services;
    }

    public function send()
    {
        $account = $this->model::get()->where('config_name', 'sms_account')->first();
        $password = $this->model::get()->where('config_name', 'sms_password')->first();
        if ($account->config_value && $password->config_value) {
            $phone = implode(',', ['0933288334']);
            $ActivateDateTime = str_replace(array('/', '+', ':'), '', date('YmdHi', strtotime('+1 minute')));
            $ActivateDateTime = (strlen($ActivateDateTime) < 14 && $ActivateDateTime) ? $ActivateDateTime . "00" : $ActivateDateTime;

            $body = '<?xml version="1.0" encoding="UTF-8"?>
                <sms>
                    <userid>' . $account->config_value . '</userid>
                    <password>' . $password->config_value . '</password>
                    <globalsms>N</globalsms>
                    <longsms>N</longsms>
                    <content>' . '測試' . date('Y-m-d H:i:s') . '</content>
                    <receivers>' . $phone . '</receivers>
                    <appointment>' . $ActivateDateTime . '</appointment>
                </sms>
            ';

            $post_data = ["xml" => $body];

            $c = curl_init();
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_URL, "http://sms.943.tw/sendapi.html");
            curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($post_data));
            $contents = curl_exec($c);
            curl_close($c);


            return $this->services::xml2array($contents);
        }
    }
}
