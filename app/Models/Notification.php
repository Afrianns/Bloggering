<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //

    protected $fillable = [
        "user_id",
        "user_liked_id",
        "user_liked_name",
        "article_liked_id",
        "article_liked_name",
    ];
}
