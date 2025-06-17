<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class Explore extends Component
{

    use WithPagination;
    
    public $categories;
    public $search = '';
    public $categoryFilter = '';

    public $page = 0;

    public $categorySelected = '';

    private $articles; 

    // #[On("getCategories")]
    public function mount()
    {   
        $this->categories = Category::all();
        
        // return $this->dispatch('categories', $this->categories);
    }

    public function searching()
    {
       $this->articles = Post::search($this->categoryFilter . $this->search)->paginate(1);
    }

    public function filterByCategory(string $category, $idx = null)
    {
        if(Str::trim($category) != ''){
            $this->categoryFilter .= $category . ' ';
        } else{
            $data = explode(' ', $this->categoryFilter);
            array_splice($data, $idx, 1);

            $this->categoryFilter = join(" ", $data);
        }
    }

    public function render()
    {
        $this->searching();
        return view('livewire.explore', [
            "articles" => $this->articles
        ]);
    }
}
