<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class basicController extends Controller
{
    public function index()
    {
        return view('basic.index');
    }
}
