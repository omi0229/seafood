<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'config';

    protected $primaryKey = 'config_name';

    protected $casts = [
        'config_name' => 'string',
    ];

    protected $fillable = [
        'config_name', 'config_value'
    ];
}
