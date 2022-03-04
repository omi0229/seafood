<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class CookingTypes extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'name',
        'location',
    ];

    public function cooking()
    {
        return $this->hasMany('App\Models\Cooking');
    }
}
