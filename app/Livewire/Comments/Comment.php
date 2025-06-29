<?php

namespace App\Livewire\Comments;

use App\Models\Comment as ModelsComment;
use App\Models\Comment_vote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class Comment extends Component
{
    public $margin;
    public $comments;

    public $ownerUserIdArticle;

    public $reply = [];

    public $editedComment = [];

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

   
    public function VoteUporDown(string $commentID, bool $vote) 
    {

        // Auth::user()->doVote($commentID, $vote);
        $res = $this->commentVote()->where("comment_id", $commentID)->first();

        if($res == null){
            Comment_vote::create([
                "user_id" => Auth::user()->id,
                "comment_id" => $commentID,
                "is_up_vote" => $vote
            ]);
        } else{
            if($res->is_up_vote == $vote){
                $res->delete();
            } else{
                Comment_vote::where("user_id", Auth::user()->id)->update([
                    "is_up_vote" => $vote
                ]);
            }
        }
    }

    public function commentVote()
    {
        return Comment_vote::where("user_id", Auth::user()->id);
    }

    // public function downVote(string $id) {
    //     $comment = ModelsComment::where("id", $id);

    //     $currentVoteCount = $comment->first()->vote_count -= 1;
        
    //     $res = $comment->update([
    //         "vote_count" => $currentVoteCount
    //     ]);
    // }

    public function deleteComment(string $commentId)
    {
        $res = ModelsComment::where("id", $commentId)->delete();
        dd($commentId, $res);
    }

    public function editComment(string $id, string $postID, string $comment)
    {

        $newEditedComment = '';

        foreach ($this->editedComment as $value) {
            
            if($value[$id]){
                $newEditedComment = $value[$id];
                break;
            }
        }

        if($newEditedComment == $comment) return;

        $result = ModelsComment::where("id", $id)->update([
            "comment" => $newEditedComment
        ]);

        if($result){
            $this->dispatch("success-update");
            return redirect("/dashboard/detail/$postID");
        }
    }

    public function render()
    {
        foreach ($this->comments as $comment) {
            array_push($this->editedComment, [ $comment->id => $comment->comment ]);
        }
        // dd($this->comments);
        return view('livewire.comments.comment',[
            "comments" => $this->comments
        ]);
    }
}
