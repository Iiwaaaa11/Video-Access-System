<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description', 
        'file_path',
        'thumbnail_path',
        'duration',
        'file_size',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function videoAccess()
    {
        return $this->hasMany(VideoAccess::class);
    }

    public function videoRequests()
    {
        return $this->hasMany(VideoRequest::class);
    }
}