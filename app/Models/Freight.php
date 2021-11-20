<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class Freight extends Model
{
    use HasFactory, SoftDeletes, HashId;

    protected $fillable = [
        'parents_id',
        'floor',
        'title',
        'start_date',
        'end_date',
        'default',
        'sort',
        'status',
        'start_total',
        'end_total',
        'freight',
    ];

    public function children()
    {
        return $this->hasMany('App\Models\Freight', 'parents_id');
    }
}
