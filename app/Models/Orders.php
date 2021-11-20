<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class Orders extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'merchant_trade_no',
        'member_id',
        'name',
        'cellphone',
        'email',
        'zipcode',
        'country',
        'city',
        'address',
        'freight_id',
        'freight_name',
        'freight',
        'delivery_method',
        'payment_method',
        'invoice_method',
        'invoice_tax_id_number',
        'invoice_name',
        'bookmark',
        'order_status',
        'payment_status',
    ];

    public function order_products()
    {
        return $this->hasMany('App\Models\OrderProducts');
    }
}
