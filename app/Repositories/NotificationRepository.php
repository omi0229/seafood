<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Repositories\Repository;

class NotificationRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Notification';
    }
}
