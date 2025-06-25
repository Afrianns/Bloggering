<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment_vote extends Model
{
    protected $fillable = [
        "user_id",
        "comment_id",
        "is_up_vote"
    ];

    public function comments()
    {
        return $this->belongsTo(Comment::class);
    }
}
