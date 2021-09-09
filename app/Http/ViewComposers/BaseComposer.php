<?php


namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Session;
use App\Models\Permission;

class BaseComposer
{
    public function compose($view)
    {
        if (Session::has('seafood_user')) {
            $view->with('permissions', Permission::all());
            $view->with('login_user', Session::get('seafood_user'));
        } else {
            $view->with('login_user', null);
            $view->with('permissions', []);
        }
    }
}
