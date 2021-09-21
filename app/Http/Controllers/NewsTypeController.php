<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsTypes;
use App\Repositories\NewsTypesRepository;
use App\Services\NewsTypesServices;
use App\Traits\General;
use App\Traits\Type;

class NewsTypeController extends Controller
{
    use General, Type;

    protected $service_name = 'news-types';

    public function __construct(NewsTypes $model, NewsTypesRepository $repository, NewsTypesServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }
}
