<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $fillable = ["score","comment","user_id","video_id"];

    function video(){
        return $this->belongsTo(Video::class);
    }
    function user(){
        return $this->belongsTo(User::class);
    }
}
