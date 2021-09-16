<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class Cooking extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $table = 'cooking';
    
    protected $fillable = [
        'cooking_types_id',
        'title',
        'start_date',
        'end_date',
        'href',
        'description',
        'keywords',
        'youtube_id',
        'target',
        'status',
    ];

    public function cooking_types()
    {
        return $this->belongsTo('App\Models\CookingTypes');
    }
}
