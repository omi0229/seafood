<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class ProductSpecifications extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'product_id',
        'name',
        'original_price',
        'selling_price',
        'inventory',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Products');
    }
}
