<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Traits\Config as TraitsConfig;

class BasicController extends Controller
{
    use TraitsConfig;

    protected $service_name = 'basic';

    protected $model;

    public function __construct(Config $model)
    {
        $this->model = $model;
    }
}
