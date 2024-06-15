<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'image',
        'video'
    ];

    protected $casts = [
        'image' => 'array',
        'video' => 'array'
    ];

    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }
    public function getAllLike(){
        return $this->hasMany(Like::class , 'post_id');

    }
    public function countLike(){
        return $this->hasMany(Like::class , 'post_id')->count();

    }
    

   

    public function comments(){
        return $this->hasMany(Comments::class);
    }
}
