<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'province',
        'regency',
        'subdistrict',
        'village',
        'type',
        'description',
        'image',
        'statement',
        'voting',
        'viewers',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }


    protected $casts = [
        'voting' => 'array',
    ];

    public function getProvinceNameAttribute()
    {
        // Ambil data provinsi dari API
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');

        if ($response->successful()) {
            $provinces = collect($response->json());
            $province = $provinces->firstWhere('id', $this->province);

            return $province['name'] ?? 'Provinsi tidak ditemukan';
        }

        return 'Provinsi tidak ditemukan';
    }

    public function getVotingCountAttribute()
    {
        return is_array($this->voting) ? count($this->voting) : 0;
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-image.jpg');
    }
}
