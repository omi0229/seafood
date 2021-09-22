<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class Product extends Model
{
    use HasFactory, SoftDeletes, HashId;

    public function product_types()
    {
        return $this->belongsTo('App\Models\ProductTypes');
    }
}
