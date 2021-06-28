<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StaffUser extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'login_id',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
