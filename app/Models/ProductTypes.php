<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class ProductTypes extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Products');
    }
}
