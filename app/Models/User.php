<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function staff()
    {
        return $this->hasOne(StaffProvinces::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class, 'staff_id');
    }

}
