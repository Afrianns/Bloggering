<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\User;
use Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Profile extends Component
{
    use WithPagination;

    public $user;

    #[Session]
    public $uuid = '';

    public $search = '';
    private $articles;

    public $type = "1";

    public function mount(string $uuid)
    {   
        $this->uuid = $uuid;

        $this->user = User::where("id", $uuid)->first();

    }

    public function setType(string $type)
    {
        $this->type = $type;
    }


    public function searchArticles()
    {
        $this->articles = $this->loadArticlesUser();
    }

    private function loadArticlesUser()
    {
        return Post::search($this->search)->options([
                'filters' => "user.id:$this->uuid AND publish:$this->type"
            ])->paginate(1);
    }

    public function render()
    {
        $this->searchArticles();
        return view('livewire.profile', [
            "articles" => $this->articles
        ]);
    }
}
