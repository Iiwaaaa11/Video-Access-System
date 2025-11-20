<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoAccess extends Model
{
    protected $table = 'video_access'; // PASTIKAN BARIS INI ADA

    protected $fillable = [
        'user_id',
        'video_id',
        'video_request_id', 
        'expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function videoRequest()
    {
        return $this->belongsTo(VideoRequest::class);
    }

    public function isValid()
    {
        return $this->expires_at > now();
    }
}