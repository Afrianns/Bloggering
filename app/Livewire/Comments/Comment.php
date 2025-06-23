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

        $this->validate([
            "reply.$commentID" => "required|min:5",
        ],[
            "reply.$commentID.required" => "The reply field is required.",
            "reply.$commentID.min" => "The reply field must be at least 5 characters."
        ]);
        
        $result = ModelsComment::create(["comment"=> $this->reply[$commentID], "user_id" => Auth::user()->id,"comment_id" => $commentID, "post_id" => $postId]);

        if($result){
            $this->dispatch("success");
            return redirect("/dashboard/detail/$postId");
        }
        // dd($this->reply[$commentID], $commentID, $postId, $validated);
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

    public function render()
    {
        return view('livewire.comments.comment',[
            "comments" => $this->comments
        ]);
    }
}
