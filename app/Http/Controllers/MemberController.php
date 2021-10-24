<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\General;
use App\Models\Member;
use App\Repositories\MembersRepository;
use App\Services\MemberServices;

class MemberController extends Controller
{
    use General;

    protected $service_name = 'member';

    protected $model, $repository, $services;

    public function __construct(Member $model, MembersRepository $repository, MemberServices $services)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->services = $services;
    }
}
