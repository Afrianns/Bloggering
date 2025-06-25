<?php

namespace App\Livewire;

use App\Models\Category_post;
use App\Models\Post;
use App\Models\vote;
use Dotenv\Util\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Session;
use Livewire\Component;

class Detail extends Component
{
    private $article;

    public function mount(string $uuid)
    {   

        $this->article = Post::where("id", $uuid)->first();

        // dd($this->article);
    
        if(!$this->article){
            return redirect('dashboard');
        }
    }

    public function deleteArticle(string $uuid)
    {
        
        // session()->flash('status-success',"failed to delete your article");
        // return $this->redirect("/dashboard");
        // session()->flash('status-success', 'Post successfully updated.');
 
        // $this->redirect('/dashboard');
        // return;
        // return $this->dispatch('status-message', "success", "successfully deleted your article");

        if($uuid){
            Post::destroy($uuid);
            $result = Category_post::where("post_id", $uuid)->delete();
            if($result) {
                session()->flash('status-success', "successfully deleted your article");
                return $this->redirect("/dashboard");
                // return $this->dispatch('status-message', "success", "successfully deleted your article");
            }
        }

        session()->flash('status-success',"failed to delete your article");
        return $this->redirect("/dashboard");
        // return $this->dispatch('status-message', "error", "failed to delete your article");
    }

    public function upVote(string $userID, string $articleID){
        
        $res = $this->getArticle($articleID)->votes()->where("user_id", $userID)->first();

        if($res == null){
            vote::create([
                "user_id" => Auth::user()->id,
                "post_id" => $articleID
            ]);
        } else{
            vote::where("post_id", $articleID)->delete();
        }

        $this->article = $this->getArticle($articleID);

    }

    private function getArticle(string $articleID)
    {
        return Post::where("id", $articleID)->first();
    }

    public function render()
    {
        return view('livewire.detail', ['article' => $this->article]);
    }
}
