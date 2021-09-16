<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class News extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'news_types_id',
        'title',
        'start_date',
        'end_date',
        'href',
        'description',
        'keywords',
        'web_img_name',
        'web_img',
        'mobile_img_name',
        'mobile_img',
        'target',
        'status',
    ];

    public function news_types()
    {
        return $this->belongsTo('App\Models\NewsTypes');
    }
}
