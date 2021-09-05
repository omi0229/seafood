<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebLogin
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
        if (\Session::has('user')) {
            $login_user = \Session::get('user');
            if (isset($login_user->token) && (new \DateTime())->getTimestamp() <= (new \DateTime($login_user->token->expires_at))->getTimestamp()) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
