<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        if (!\Session::has('user')) {
            return redirect('/login');
        }

        $login_user = \Session::get('user');

        if (!isset($login_user->token)) {
            return redirect('/login');
        }

        if ((new \DateTime())->getTimestamp() > (new \DateTime($login_user->token->expires_at))->getTimestamp()) {
            return redirect('/login');
        }

        return $next($request);
    }
}
