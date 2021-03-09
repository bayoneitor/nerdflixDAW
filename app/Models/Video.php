<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ["title","cont","user_id","route_video","route_miniature","route_frame"];

    function scores(){
        return $this->hasMany(Score::class);
    }
    function user(){
        return $this->belongsTo(User::class);
    }
    public function usersWatched(){
        return $this->belongsToMany(User::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
