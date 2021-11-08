<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class Cart extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'cart_id',
        'specifications_id',
        'count',
    ];

    public function product_specification()
    {
        return $this->belongsTo('App\Models\ProductSpecifications', 'specifications_id');
    }
}
