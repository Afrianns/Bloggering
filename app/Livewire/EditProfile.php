<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Component;

class EditProfile extends Component
{
    public $name = '';
    public $email = '';

    public $address = '';
    public $description = '';

    public $links;

    #[Session]
    public $uuid = '';

    public function mount(string $uuid)
    {
        $res = User::find($uuid);
        $this->name = $res->name;
        $this->email = $res->email;

        $this->uuid = $uuid;
    }


    public function updateProfile()
    {

        $validated = $this->validate([
            "name" => "required|min:5",
            "email" => [
                        "required",
                        "min:5",
                        "email:dns.rfc",
                        Rule::unique("users")->ignore($this->uuid)
                    ],
        ]);

        $result = User::where("id", $this->uuid)->update($validated);

        if($result){
            return $this->dispatch('status-message', "success", "your profile successfully updated");
        }

        return $this->dispatch('status-message', "failed", "profile failed to update");
    }

    public function updateProfileDetails()
    {

    }

    // #[On("save-links")]
    public function gettingLinks(array $links)
    {
        dd($links);   
    } 

    public function render()
    {
        return view('livewire.edit-profile');
    }
}
