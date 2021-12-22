<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\LoginServices;

class WebAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!\Session::has('seafood_user')) {
            return redirect('/login');
        }

        $actionUri = \Route::current()->uri;
        $type = explode('/', $actionUri)[0];

        $array = [
            'basic' => 'set_basic',
            'role' => 'set_manager',
            'user' => 'set_manager',
            'sms' => 'set_message',
            'banners' => 'banners',
            'news-type' => 'news-type',
            'news' => 'news',
            'cooking-type' => 'cooking-type',
            'cooking' => 'cooking',
            'product-type' => 'product-type',
            'product' => 'product',
            'product-specification' => 'product',
            'directory' => 'directory',
            'put-on' => 'put-on',
            'member' => 'member',
            'freight' => 'freight',
            'orders' => 'orders',
            'pages' => 'pages',
            'discount-code' => 'discount-code',
            'coupon' => 'coupon',
        ];

        $login_user = \Session::get('seafood_user');

        # 如找不到權限，則登出 or 若沒有此功能權限，則登出
        if ($type !== '') {
            if (!(isset($array[$type]) && $login_user->can($array[$type]))) {
                LoginServices::logout();
                return redirect('/login');
            }
        }

        # 若沒有token，則登出
        if (!isset($login_user->token)) {
            LoginServices::logout();
            return redirect('/login');
        }

        # 若token過期，則登出
        if ((new \DateTime())->getTimestamp() > (new \DateTime($login_user->token->expires_at))->getTimestamp()) {
            LoginServices::logout();
            return redirect('/login');
        }

        return $next($request);
    }
}
