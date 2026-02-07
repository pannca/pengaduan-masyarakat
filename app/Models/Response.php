<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    //

    protected $fillable = [
        'report_id',
        'response_status',
        'response_progress'
    ];

    // Model Response
    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function response_progress()
    {
        return $this->hasMany(Response_Progress::class);
    }
}
