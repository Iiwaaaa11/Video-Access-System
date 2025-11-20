<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoRequest extends Model
{
    // Specify the actual table name
    protected $table = 'video_requests';

    protected $fillable = [
        'user_id',
        'video_id', 
        'status',
        'admin_notes'
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan Video
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    // Relationship dengan VideoAccess (jika approved)
    public function videoAccess()
    {
        return $this->hasOne(VideoAccess::class, 'video_request_id');
    }
}