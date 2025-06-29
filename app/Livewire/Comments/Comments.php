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

    public $ownerUserIdArticle;

    public function commenting()
    {
        $validated = $this->validate([
            "comment" => "required|min:5",
            "post_id" => "required",
        ]);

        $result = Comment::create(array_merge($validated, ['user_id' => Auth::user()->id]));

        if($result){
            $this->dispatch("success");
            return redirect("/dashboard/detail/$this->post_id");
        }
    }

    public function render()
    {
        return view('livewire.comments.comments',[
            "comments" => $this->comments
        ]);
    }
}
