<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class Role extends SpatieRole
{
    use SoftDeletes, HashId;
}
