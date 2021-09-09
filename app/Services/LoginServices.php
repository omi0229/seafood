<?php


namespace App\Services;

use Illuminate\Support\Facades\Session;
use App\Models\OauthAccessTokens;

class LoginServices
{
    static function logout()
    {
        $login_user = Session::get('seafood_user');

        if ($login_user) {
            $token_info = OauthAccessTokens::find($login_user->token->id);
            if ($token_info) {
                $token_info->update(['revoked' => 1]);
            }
        }

        Session::flush();

        return true;
    }
}
