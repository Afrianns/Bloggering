<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $fillable = [
        "comment",
        "user_id",
        "post_id",
        "comment_id",
        "up_vote",
        "down_vote",
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function article(){
        return $this->belongsTo(Post::class);
    }

    public function replies() {
        return $this->hasMany(Comment::class);
    }
}
