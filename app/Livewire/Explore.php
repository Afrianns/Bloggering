<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Explore extends Component
{

    use WithPagination;

    public Collection $articles;
    
    public $categories;
    public $search = '';

    public $page = 0;

    public function mount()
    {   
        $this->articles = collect();
        $this->categories = Category::all();
    }


    public function loadMoreArticles()
    {
        $this->page = $this->page + 1;
    }

    public function getArticles()
    {
        $this->articles->push(...Post::search($this->search)->options(['page' => $this->page, "hitsPerPage" => 1])->get());
        
    }


    #[Computed]
    public function countTotalArticles()
    {
        return Post::all()->count();
    }

    public function render()
    {
        $this->getArticles();
        return view('livewire.explore', [
            "articles" => $this->articles
        ]);
    }
}
