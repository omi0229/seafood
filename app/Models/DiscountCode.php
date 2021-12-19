<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class DiscountCode extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'title',
        'records',
        'full_amount',
        'discount',
        'is_fixed',
        'fixed_name',
        'start_date',
        'end_date',
    ];

    public function discount_records()
    {
        return $this->hasMany('App\Models\DiscountRecord', 'discount_codes_id');
    }
}
