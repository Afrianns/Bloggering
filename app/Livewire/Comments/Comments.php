<?php

namespace App\Livewire\Comments;

use App\Models\Comment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Comments extends Component
{

    public $comment = '';
    public $post_id;
    public $comments;

    public function commenting()
    {
        $validated = $this->validate([
            "comment" => "required|min:5",
            "post_id" => "required",
        ]);

        Comment::create(array_merge($validated, ['user_id' => Auth::user()->id]));
    }

    public function render()
    {
        return view('livewire.comments.comments');
    }
}
