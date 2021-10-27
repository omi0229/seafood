<?php


namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Config;

class SmsServices
{
    protected $request, $config;

    public function __construct(Request $request, Config $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    static function xml2array($XMLData)
    {
        $xml = simplexml_load_string($XMLData);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);

        return $array;
    }

    public function queryPoints()
    {
        $user_name = data_get($this->request->all(), 'sms_account');
        $password = data_get($this->request->all(), 'sms_password');

        $body = '<?xml version="1.0" encoding="UTF-8"?>
			<sms>
				<userid>' . $user_name . '</userid>
				<password>' . $password . '</password>
			</sms>';

        $post_data = ["xml" => $body];

        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, "http://sms.943.tw/querypointsapi.html");
        curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($post_data));
        $contents = curl_exec($c);
        curl_close($c);

        return self::xml2array($contents);
    }

    public function send(array $array, $code, $type = 'sms_code')
    {
        $account = $this->config::where('config_name', 'sms_account')->first();
        $password = $this->config::where('config_name', 'sms_password')->first();
        if ($account->config_value && $password->config_value) {
            $phone = implode(',', $array);
            $ActivateDateTime = str_replace(array('/', '+', ':'), '', date('YmdHi', strtotime('+1 minute')));
            $ActivateDateTime = (strlen($ActivateDateTime) < 14 && $ActivateDateTime) ? $ActivateDateTime . "00" : $ActivateDateTime;

            $message = $type == 'forget_password' ? '您的密碼為' . $code : '海龍王註冊訊息：您的註冊碼為 ' . $code;

            $body = '<?xml version="1.0" encoding="UTF-8"?>
                <sms>
                    <userid>' . $account->config_value . '</userid>
                    <password>' . $password->config_value . '</password>
                    <globalsms>N</globalsms>
                    <longsms>N</longsms>
                    <content>' . $message . ' </content>
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


            return self::xml2array($contents);
        }

        return ['status' => -100];
    }
}
