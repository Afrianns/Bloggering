<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Workbench\App\Models\User;

class User_detail extends Model
{
    protected $fillable = [
        'country',
        'address',
        'description',
        'links',
        "user_id"
    ];



    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
