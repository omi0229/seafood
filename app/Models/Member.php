<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashId;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, HashId;

    protected $table = 'members';

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'cellphone',
        'password',
        'name',
        'email',
        'telephone',
        'zipcode',
        'country',
        'city',
        'address',
        'active',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}