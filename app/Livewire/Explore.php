<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Explore extends Component
{

    use WithPagination;
    
    public $categories;
    public $search = '';
    public $categoryFilter = '';
    public $categoryFilterHome = '';

    public $page = 0;

    public $categorySelected = '';

    private $articles; 

    public function mount()
    {   
        if(request()->category){
            $this->categoryFilterHome = request()->category . " ";
        }
        $this->categories = Category::all();
        
        // return $this->dispatch('categories', $this->categories);
    }

    public function searching()
    {
       return Post::search($this->categoryFilter . $this->search)->paginate(1);
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
        $this->articles = $this->searching();

        // dd($this->articles->count());
        return view('livewire.explore', [
            "articles" => $this->articles
        ]);
    }
}
