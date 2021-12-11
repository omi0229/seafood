<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class Products extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'product_types_id',
        'title',
        'content',
        'keywords',
        'description',
        'product_front_cover_image_id',
        'product_mobile_front_cover_image_id',
        'web_img_name',
        'web_img',
        'mobile_img_name',
        'mobile_img',
        'sales_status',
        'show_status',
    ];

    public function product_types()
    {
        return $this->belongsTo('App\Models\ProductTypes');
    }

    public function product_specification()
    {
        return $this->hasMany('App\Models\ProductSpecifications', 'product_id');
    }

    public function product_images()
    {
        return $this->hasMany('App\Models\ProductImages', 'product_id');
    }

    public function put_ons()
    {
        return $this->hasMany('App\Models\PutOn', 'product_id');
    }
}
