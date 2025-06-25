<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasUuids, Searchable;

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'Category_posts');
    }

    public function toSearchableArray()
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->categories()->get(),
            'user' => $this->user()->get()

        ];
    }


    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull("comment_id")->latest();
    }

    public function votes()
    {
        return $this->hasOne(vote::class);
    }

    public function isUserVote(string $user_id)
    {
        return $this->hasOne(vote::class)->where("user_id", $user_id)->count();
    }

}
