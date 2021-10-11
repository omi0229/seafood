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
        return $this->hasOne('App\Models\Directory');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products');
    }
}
