<?php

namespace App\Livewire;

use App\Models\Category_post;
use App\Models\Post;
use Livewire\Component;

class Detail extends Component
{
    private $article;
    public function mount(string $uuid)
    {   
        $this->article = Post::where("id", $uuid)->first();
    }

    public function deleteArticle(string $uuid)
    {
        
        session()->flash('status-success', 'Post successfully updated.');
 
        $this->redirect('/dashboard');
        return;
        // return $this->dispatch('status-message', "success", "successfully deleted your article");

        if($uuid){
            $post = Post::destroy($uuid);
            $result = Category_post::where("post_id", $uuid)->delete();
            dd($uuid, $result, $post);
            // redirect('/dashboard');
            return $this->dispatch('status-message', "success", "successfully deleted your article");

        } else{
            return $this->dispatch('status-message', "error", "failed to delete your article");
        }
    }

    public function render()
    {
        return view('livewire.detail', ['article' => $this->article]);
    }
}
