<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class PutOn extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'directories_id',
        'product_id',
        'start_date',
        'end_date',
        'status',
    ];

    public function directory()
    {
        return $this->belongsTo('App\Models\Directory', 'directories_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products');
    }

    public function order_products()
    {
        return $this->hasMany('App\Models\OrderProducts', 'product_id');
    }
}
