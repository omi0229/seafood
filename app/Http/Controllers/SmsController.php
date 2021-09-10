<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Traits\Config as TraitsConfig;

class SmsController extends Controller
{
    use TraitsConfig;

    protected $service_name = 'sms';

    protected $model;

    public function __construct(Config $model)
    {
        $this->model = $model;
    }
}
