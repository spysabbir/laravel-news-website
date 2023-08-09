<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment_reply extends Model
{
    use HasFactory;
    protected $guarded = [];

    function relationtouser(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
