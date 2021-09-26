<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class Directory extends Model
{
    use HasFactory, SoftDeletes, HashId;

    public $table = 'directories';

    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Products');
    }
}
