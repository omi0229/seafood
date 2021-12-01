<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Repository;

class PagesRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Pages';
    }

    public function apiInfo($type)
    {
        if ($type === 'shopping-explanation') {
            $type = 'shopping_explanation';
        }

        return app()->make($this->model())->where('type', $type)->get()->first();
    }
}
