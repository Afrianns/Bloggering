<?php

namespace App\Livewire\ProfileMenu;

use App\Models\Post;
use Livewire\Component;

class PublishedArticles extends Component
{
    public $article;

    // public $search = "";

    // public $uuid = "";

    // public function mount($articles){
    //     $this->articles = $articles;
    // }

    // public function mount(string $uuid)
    // {
    //     $this->uuid = $uuid;

    //     $this->articles = $this->loadArticlesUser();
    // }

    // public function searchArticles()
    // {
    //     $this->articles = $this->loadArticlesUser();
    // }

    // private function loadArticlesUser()
    // {
    //     return Post::search($this->search)->options([
    //             'filters' => "user.id:$this->uuid AND publish:1"
    //         ])->paginate(1);
    // }

    public function render()
    {
        // dd($this->articles, "s");
       return view('livewire.profile-menu.published-articles',[
            "article" => $this->article
       ]);
    }
}
