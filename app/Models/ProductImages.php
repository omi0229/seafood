<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class ProductImages extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'name',
        'product_id',
        'path',
        'type',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Products');
    }
}
