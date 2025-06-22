<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Category_post;
use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Str;

class AddNewArticle extends Component
{

    public $title = '';
    public $categories = [];
    public $contents = '';

    public $availCategoriesKeys = [];
    public $availCategories = array();

    public function save()
    {
        $this->validate([
            'title' => "required|min:5",
            'contents' => "required|min:15"
        ]);

        $ca = Category::upsert($this->categories, ['name']);
        
        $po = Post::create([
            'title' => $this->title,
            'subtitle' => Str::slug($this->title, '-'),
            'content' => $this->contents,
            'user_id' => Auth::user()->id
        ]);

        if($ca == count($this->categories)){
            $this->getCategories();
            
            $categoriesStructured = [];
            // dump($this->categories);

            foreach ($this->availCategoriesKeys as $selectedKey => $selectedValue) {
                array_push($categoriesStructured, ['post_id' => $po->id, 'category_id' => $selectedValue]);
            };
            
            foreach ($this->availCategories as $key => $value) {
                $isSameSelected = false;
                foreach ($this->availCategoriesKeys as $selectedKey => $selectedValue) {
                    if($key == $selectedKey) {
                        $isSameSelected = true;
                    }
                };
                if(!$isSameSelected && $this->filteredValue($value)){
                    array_push($categoriesStructured, ['post_id' => $po->id, 'category_id' => array_keys($value)[0]]);
                }
            };

            $cpo = Category_post::upsert($categoriesStructured, ['category_id']);
            
            $this->title = '';
            $this->categories = [];
            $this->contents = '';
            return $this->dispatch('status-message', "success", "your article successfully published");
            // dd($this->title, $this->categories, $this->contents, $po, $ca, $cpo, $categoriesStructured);
        } else{
            return $this->dispatch('status-message', "error", "failed to publish your article!");
        }
    }

    public function filteredValue($value)
    {
        $result = false;
        foreach ($this->categories as $k => $categoryValue) {
            if(Arr::flatten($value)[0] == $categoryValue['name']){
                $result = true;
                break;
            }
        }

        return $result;
    }


    #[On("userInput")]
    public function getContents($contents, $categories, $availCategories)
    {
        $this->contents = $contents;
        $this->availCategoriesKeys = $availCategories;
        $structuredCategories = Arr::map($categories, function(string $value, string $key) {
            return ['name' => $value];
        });
        $this->categories = $structuredCategories;
    }

    public function getCategories() {
        foreach (Category::all() as $category) {
           array_push($this->availCategories, [$category->id => $category->name]);
        }
    }


    public function render()
    {
        $this->getCategories();
        // dd($this->availCategories);
        return view('livewire.add-new-article');
    }
}
