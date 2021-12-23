<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class Coupon extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'title',
        'coupon',
        'full_amount',
        'discount',
        'start_date',
        'end_date',
    ];
}
