<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Category_post;
use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    
    private $articles;

    private $categories;
    
    private $articles_categories;

    public function getAllArticlesInformations()
    {
        $this->articles = $this->getArticles();
        $this->categories = Category::all();
        $this->articles_categories = Category_post::all();
    }

    public function getArticles()
    {
        return Post::where("publish", true)->paginate(1);
    }

    public function render()
    {
        $this->getAllArticlesInformations();
        return view('livewire.home',['articles' => $this->articles, 'categories' => $this->categories, 'articles_categories' => $this->articles_categories]);
    }

}
