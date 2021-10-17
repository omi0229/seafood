<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Http\Request;

class MembersRepository extends Repository
{
    protected $request;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    public function model()
    {
        return 'App\Models\Member';
    }
}
