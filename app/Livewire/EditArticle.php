<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Category_post;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Str;

class EditArticle extends Component
{

    public $title = '';
    public $categories = [];
    public $contents = '';

    public $availCategories = [];

    public $articleCategories = [];
    public $articleCategoryKeys = [];
    public $availCategoriesKeys = [];

    public $article;

    public $currentArticleUuid = '';

    public function mount(string $uuid)
    {
        $this->currentArticleUuid = $uuid;

        $this->article = Post::where("id", $uuid)->first();

        $this->title = $this->article->title;
        $this->contents = $this->article->content;

       foreach($this->article->categories()->get() as $category) {
            array_push($this->articleCategories, $category->name);
            array_push($this->articleCategoryKeys, $category->id);
       };
    }

    public function save()
    {
        if(!$this->currentArticleUuid) return $this->dispatch('status-message', "error", "There is an error occur with article ID");
 

        $this->validate([
            'title' => "required|min:5",
            'contents' => "required|min:15"
        ]);
        
        Post::where("id", $this->currentArticleUuid)->update([
            'title' => $this->title,
            'subtitle' => Str::slug($this->title, '-'),
            'content' => $this->contents,
            'user_id' => Auth::user()->id
        ]);
        
        $ca = Category::upsert($this->categories, ['name']);

        if($ca == count($this->categories)){
            $this->getCategories();
            
            $categoriesStructured = [];

            foreach ($this->availCategoriesKeys as $selectedKey => $selectedValue) {
                array_push($categoriesStructured, ['post_id' => $this->currentArticleUuid, 'category_id' => $selectedValue]);
            };
            
            foreach ($this->availCategories as $key => $value) {
                $isSameSelected = false;
                foreach ($this->availCategoriesKeys as $selectedKey => $selectedValue) {
                    if($key == $selectedKey) {
                        $isSameSelected = true;
                    }
                };
                if(!$isSameSelected && $this->filteredValue($value)){
                    array_push($categoriesStructured, ['post_id' => $this->currentArticleUuid, 'category_id' => array_keys($value)[0]]);
                }
            };
            $this->getCategoriesPivotTable();

            Category_post::upsert($categoriesStructured, ['category_id']);
            
            $this->categories = [];
            $this->contents = '';
            return $this->dispatch('status-message', "success", "your article successfully published");
        } else{
            return $this->dispatch('status-message', "error", "failed to publish your article!");
        }
    }

    public function getCategoriesPivotTable()
    {
        $data = Post::where("id", $this->currentArticleUuid)->first();

        $notDeletedCategories = [];
        $deletedCategories = [];


        $result = $this->findNotMatchInArray($data->categories()->get(), $this->availCategoriesKeys, "spl-category-id");

        $notDeletedCategories = $result[0];
        $deletedCategories = $result[1];

        // foreach ($data->categories()->get() as $categoryExist) {
            
        //     $isExist = false;

        //     foreach($this->availCategoriesKeys as $availCategoryKey){
        //         if($categoryExist->id == $availCategoryKey){
        //             $isExist = true;
        //             array_push($notDeletedCategories, $categoryExist->id);
        //             dump($categoryExist->id);
        //         }
        //     }

        //     if(!$isExist){
        //         array_push($deletedCategories, $categoryExist->id);
        //     }
        // }
        Post::find($this->currentArticleUuid)->categories()->detach($deletedCategories);
        // dd($data->categories()->get(), $this->availCategoriesKeys, $notDeletedCategories, $deletedCategories);
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
    public function getContents($contents, $categories)
    {
        $this->contents = $contents;
        // $this->availCategoriesKeys = $availCategories;


        $CategoryDB = Category::all();

        $result = $this->findNotMatchInArray($categories, $CategoryDB);
        $alreadyExistCategories = $result[0];
        $notExistYetCategories = $result[1];
        // foreach ($categories as $categorySelected) {
        //     $isExist = false;
            
        //     foreach ($CategoryDB as $category) {
        //         if(Str::trim(Str::lower($categorySelected)) == Str::trim(Str::lower($category->name))){
        //             array_push($alreadyExistCategories , $category->id);

        //             $isExist = true;
        //             break;
        //         }
        //     }

        //     if(!$isExist){
        //         array_push($notExistYetCategories, $categorySelected);
        //     }
        // }

        $this->availCategoriesKeys = $alreadyExistCategories;

        // dd($alreadyExistCategories, $categories, $notExistYetCategories);

        $structuredCategories = Arr::map($notExistYetCategories, function(string $value) {
            return ['name' => $value];
        });
        $this->categories = $structuredCategories;
    }

    public function getCategories() {
        foreach (Category::all() as $category) {
           array_push($this->availCategories, [$category->id => $category->name]);
        }
    }


    private function findNotMatchInArray($datasFirst, $datasSecond, $split = "spl-category-name")
    {

        $alreadyExist = [];
        $notExistYet = [];

        foreach ($datasFirst as $dataFirst) {
            $isExist = false;
            
            foreach ($datasSecond as $dataSecond) {
                if($split == "spl-category-id"){
                    // spliting categories to get ID separate
                    if($dataFirst->id == $dataSecond){
                        $isExist = true;
                        array_push($alreadyExist , $dataFirst->id);
                        break;
                    }
                } else {
                    // spliting categories from frontend form
                    if($dataFirst == $dataSecond->name){
                        array_push($alreadyExist, $dataSecond->id);
                        
                        $isExist = true;
                        break;
                    }
                }
            }

            if(!$isExist){
                if($split == "spl-category-id"){
                    array_push($notExistYet, $dataFirst->id);
                } else{
                    array_push($notExistYet, $dataFirst);
                }
            }
        }

        return [$alreadyExist, $notExistYet];
    }

    public function render()
    {
       $this->getCategories();
        return view('livewire.edit-article');
    }
}
