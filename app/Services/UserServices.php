<?php


namespace App\Services;

use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserServices
{
    static $model = 'App\Models\User';

    static function authInputData(&$inputs)
    {
        $model = app()->make(self::$model);

        $auth = [
            'account' => [
                'required',
                Rule::unique('users')->ignore($model::find($model::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
            'name' => 'required',
            'email' => 'required|email',
        ];

        $tip = [
            'account.required' => '請填寫帳號',
            'account.unique' => '已有重複帳號',
            'name.required' => '請填寫姓名',
            'email.email' => '請輸入正確email',
        ];

        if (data_get($inputs, 'password')) {
            $auth['password'] =  'required';
            $auth['auth_password'] =  'required';
            $tip['password.required'] =  '請填寫密碼';
            $tip['auth_password.required'] =  '請填寫確認密碼';
        }

        return Validator::make($inputs, $auth, $tip);
    }

    public function getLineNotifyToken($inputs)
    {
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://notify-bot.line.me/oauth/token",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => array(
				'grant_type' => 'authorization_code',
				'redirect_uri' => env('APP_URL') . '/user/line-notify',
				'client_id' => env('LINE.NOTIFY.CLIENT_ID'),
				'client_secret' => env('LINE.NOTIFY.CLIENT_SECRET'),
				'code' => $inputs['code']
			),
		));
		$response = curl_exec($curl);

		curl_close($curl);

        return json_decode($response, true);
    }

    public function pushLineNotify(array $line_notify_info, $message)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://notify-api.line.me/api/notify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => ['message' => $message],
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $line_notify_info['access_token']
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
    }
}
