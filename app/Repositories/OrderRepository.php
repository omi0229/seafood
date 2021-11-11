<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Repository;

class OrderRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Orders';
    }
}
