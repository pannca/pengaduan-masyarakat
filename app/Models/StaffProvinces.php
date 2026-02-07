<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffProvinces extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'province',
    ];

    public function report()
    {
        return $this->hasOne(Report::class); // Pastikan tipe relasi sesuai
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($staffProvinces) {
            $staffProvinces->user()->delete(); // Hapus data user terkait
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Sesuaikan dengan foreign key Anda
    }
}
