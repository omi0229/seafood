<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class OrderProducts extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'orders_id',
        'product_id',
        'product_specifications_id',
        'count',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Orders', 'orders_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products')->withTrashed();
    }

    public function product_specifications()
    {
        return $this->belongsTo('App\Models\ProductSpecifications')->withTrashed();
    }

    public function put_on()
    {
        return $this->belongsTo('App\Models\PutOn');
    }
}
