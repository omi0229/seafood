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
        'TradeNo',
        'BankCode',
        'vAccount',
        'ExpireDate',
        'invoice_method',
        'invoice_tax_id_number',
        'invoice_name',
        'bookmark',
        'shipment_at',
        'MerchantTradeNo',
        'AllPayLogisticsID',
        'BookingNote',
        'RtnCode',
        'RtnMsg',
        'admin_bookmark',
        'order_status',
        'payment_status',
    ];

    public function member()
    {
        return $this->belongsTo('App\Models\Member');
    }

    public function order_products()
    {
        return $this->hasMany('App\Models\OrderProducts');
    }

    public function payment_data()
    {
        return $this->hasOne('App\Models\Log', 'data_id')->where('type', 'payment');
    }

    public function discount_record()
    {
        return $this->hasMany('App\Models\DiscountRecord');
    }
}
