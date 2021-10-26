<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Services\SmsServices;

class SmsController extends Controller
{
    protected $model, $request, $services;

    public function __construct(Config $model, Request $request, SmsServices $services)
    {
        $this->model = $model;
        $this->request = $request;
        $this->services = $services;
    }
}
