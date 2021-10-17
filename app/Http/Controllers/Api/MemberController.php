<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\MembersRepository;
use App\Services\MemberServices;

class MemberController extends Controller
{
    protected $request, $repository, $services;

    public function __construct(Request $request, MembersRepository $repository, MemberServices $services)
    {
        $this->request = $request;
        $this->repository = $repository;
        $this->services = $services;
    }

    public function insert()
    {
        # 驗證資料
        $validator = $this->services::authInputData($this->request, 'create');
        if (!$validator['status']) {
            return response()->json(['status' => false, 'message' => $validator['message']]);
        }

        $this->repository->create($this->request->all());

        return response()->json(['status' => true, 'message' => '註冊成功']);
    }
}
