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
    
    public Collection $articles;

    private $categories;
    
    private $articles_categories;

    private $page = 1;

    public function mount()
    {
        $this->articles = collect();
    }

    public function getAllArticlesInformations()
    {
        $this->getArticles();
        $this->categories = Category::all();
        $this->articles_categories = Category_post::all();
    }

    public function loadMoreArticles()
    {
        $this->page = $this->page + 1;
    }

    public function getArticles()
    {
        $this->articles->push(...$this->articlePaginate());
    }


    #[Computed]
    public function articlePaginate()
    {
        return Post::paginate(1, ['*'], 'page', $this->page);
    }

    public function render()
    {
        $this->getAllArticlesInformations();
        return view('livewire.home',['articles' => $this->articles, 'categories' => $this->categories, 'articles_categories' => $this->articles_categories]);
    }

}
