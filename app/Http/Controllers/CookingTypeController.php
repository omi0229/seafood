<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CookingTypes;
use App\Repositories\CookingTypesRepository;
use App\Services\CookingTypesServices;
use App\Traits\General;
use App\Traits\Type;

class CookingTypeController extends Controller
{
    use General, Type;

    protected $service_name = 'cooking-types';

    public function __construct(CookingTypes $model, CookingTypesRepository $repository, CookingTypesServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }
}
