<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

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
