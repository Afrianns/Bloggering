<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    
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
    
    public function votesCount(string $commentID){
        $upVoteCount = $this->votes()->where("comment_id", $commentID)->where("is_up_vote", true)->count();
        $downVoteCount = $this->votes()->where("comment_id", $commentID)->where("is_up_vote", false)->count();
        return $upVoteCount - $downVoteCount;
    }

    public function votes(){
        return $this->hasMany(Comment_vote::class);
    }
}
