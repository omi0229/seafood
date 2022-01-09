<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;
use App\Models\Config;

class ProductSpecifications extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'product_id',
        'name',
        'original_price',
        'selling_price',
        'inventory',
        'unit',
    ];

    public function getOriginalPriceAttribute($original_price)
    {
        $discount = Config::firstWhere('config_name', 'basic_all_discount');
        if ($discount && is_numeric($discount->config_value) && $discount->config_value > 0 && \Route::getCurrentRoute()->uri !== 'product-specification/list/{id}') {
            return ceil(($original_price * $discount->config_value) / 100);
        }

        return $original_price;
    }

    public function getSellingPriceAttribute($selling_price)
    {
        $discount = Config::firstWhere('config_name', 'basic_all_discount');
        if ($discount && is_numeric($discount->config_value) && $discount->config_value > 0 && \Route::getCurrentRoute()->uri !== 'product-specification/list/{id}') {
            return ceil(($selling_price * $discount->config_value) / 100);
        }

       return $selling_price;
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products');
    }
}
