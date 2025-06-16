<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Explore extends Component
{

    use WithPagination;
    
    public $categories;
    public $search = '';

    public $page = 0;

    public function mount()
    {   
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.explore', [
            "articles" => Post::search($this->search)->paginate(1)
        ]);
    }
}
