<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['video_url'];

    public static function store($request)
    {
        // Store the uploaded file and get its path
        $video = $request->file('video')->store('videos', 'public');

        // Create a new media record and save its path
        return self::create(['video' => $video]);
    }
}
