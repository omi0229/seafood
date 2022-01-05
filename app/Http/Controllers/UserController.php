<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\General;
use App\Models\User;
use App\Models\Role;
use App\Repositories\UsersRepository;
use App\Services\UserServices;

class UserController extends Controller
{
    use General;

    protected $service_name = 'user';

    protected $model, $repository, $services;

    public function __construct(User $model, UsersRepository $repository, UserServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function insert(Request $request)
    {
        $inputs = $request->all();

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $inputs['password'] = Hash::make($inputs['password']);

        $user = $this->model::create($inputs);
        if (isset($inputs['role']['id'])) {
            $user->assignRole(Role::decodeSlug($inputs['role']['id']));
        }

        return response()->json(['status' => true, 'message' => '新增成功']);
    }

    public function update(Request $request)
    {
        if (!data_get($request->all(), 'id')) {
            return response()->json(['status' => false, 'message' => '修改失敗']);
        }

        $user_id = $request->all()['id'];
        $inputs = $request->only('id', 'account', 'name', 'email', 'password', 'auth_password', 'role', 'active');

        # 驗證資料
        $validator = $this->services::authInputData($inputs);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $user = $this->model::find($this->model::decodeSlug($user_id));
        if ($user) {
            if (data_get($inputs, 'password')) {
                $inputs['password'] = Hash::make($inputs['password']);
            } else {
                unset($inputs['password']);
            }

            $user->update($inputs);
            if (isset($inputs['role']['id'])) {
                $user->syncRoles(Role::decodeSlug($inputs['role']['id']));
            }
            return response()->json(['status' => true, 'message' => '編輯成功']);
        } else {
            return response()->json(['status' => false, 'message' => '無此人員資料']);
        }
    }

    public function lineNotify(Request $request)
    {
        $inputs = $request->all();

        dump($inputs);

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
		$array = json_decode($response, true);

        dd($array);
    }
}
