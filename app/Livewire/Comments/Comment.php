<?php

namespace App\Livewire\Comments;

use App\Models\Comment as ModelsComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Comment extends Component
{
    public $margin;
    public $comments;

    public $reply = [];

    public function replying($commentID, $postId){

        dd($this->reply, $commentID, $postId);
    }

    // public function replying($key, $commentID, $postID, $text)
    // {

    //     if(trim($text) == "" || !$text){
    //         $this->dispatch("error");
    //     }


    //     // dd($key, $commentID, $postID, $text);

    //     $validated = $this->validate([
    //         "reply" => "required|min:5",
    //     ]);

    //     // ModelsComment::create(["comment"=> $this->reply,"user_id" => Auth::user()->id,"comment_id" => $commentID, "post_id" => $postID]);
    //     // dd($this->reply, $commentID);
    // }

    public function getComment()
    {
        return $this->comments;   
    }

    public function render()
    {
        // dd($this->margin);
        return view('livewire.comments.comment');
    }
}
