<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['image_url'];

    public static function list(){
        return self::all();
    }

    public function profile(){
        return $this->belongsTo(Profile::class, 'id', 'image_id');
    }
}
