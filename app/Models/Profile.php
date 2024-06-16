<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'image_id', 'bio'];

    public static function list(){
        return self::all();
    }

    public function image(){
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function createOrUpdate($request, $id = null){
        $data = $request->only('user_id', 'image_id', 'bio');
        return self::updateOrCreate(['id' => $id], $data);
    }
}
