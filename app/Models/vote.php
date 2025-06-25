<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vote extends Model
{
    protected $fillable =[
        "user_id",
        "post_id"
    ];

    public function posts(){
        return $this->belongsTo(Post::class);
    }

}
