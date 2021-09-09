<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\OauthAccessTokens;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'account' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('account', 'password');

        $user = User::where('account', $credentials['account'])->where('active', 1)->first();
        $validCredentials = \Hash::check($credentials['password'], optional($user)->getAuthPassword());

        if (!$validCredentials) {
            return response()->json(['status' => false, 'message' => '帳號或密碼錯誤']);
        }

        # 取得token
        $token = $user->createToken('web');
        $user->access_token = $token->accessToken;
        $token_info = OauthAccessTokens::find($token->token->id);
        $token_info->update(['expires_at' => Carbon::now()->addHours(2)->format('Y-m-d H:i:s')]);
        $user->token = $token_info;

		Session::put('seafood_user', $user);

        return response()->json(['status' => true, 'message' => '登入成功']);
    }

    public function logout()
    {
        \App\Services\LoginServices::logout();

        return response()->json(['status' => true, 'message' => '登出成功']);
    }
}
