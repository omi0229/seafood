<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class DiscountRecord extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'type',
        'discount_codes_id',
        'orders_id',
        'member_id',
        'cart_id',
        'received_at',
        'used_at',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Orders', 'orders_id', 'id');
    }

    public function discount_codes()
    {
        return $this->belongsTo('App\Models\DiscountCode');
    }

    public function coupon()
    {
        return $this->belongsTo('App\Models\Coupon', 'discount_codes_id');
    }
}
