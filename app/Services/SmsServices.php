<?php


namespace App\Services;

use Illuminate\Http\Request;

class SmsServices
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
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
}
