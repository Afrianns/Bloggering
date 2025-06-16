<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    public function Users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'Category_posts');
    }
}
