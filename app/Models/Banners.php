<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class Banners extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'href',
        'web_img_name',
        'web_img',
        'mobile_img_name',
        'mobile_img',
        'target',
        'status',
    ];
}
