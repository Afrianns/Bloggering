<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\User_detail;
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

        if($res->details){
            $this->address  = $res->details->address;
            $this->description = $res->details->description;
            $this->links  = $res->details->links;
        }
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
        
        $this->validate([
            "address" => "min:5",
            "description" => "min:10",
        ]);
        
        
        $result = User_detail::updateOrCreate(
            ["user_id" => $this->uuid],
            ["user_id" => $this->uuid, "address" => $this->address, "description" => $this->description, "links" => json_encode($this->links)]
        );


        if($result){
            return $this->dispatch('status-message', "success", "your profile details successfully updated");
        }
        return $this->dispatch('status-message', "failed", "profile details failed to update");
        // dd($this->address, $this->description, json_encode($this->links), $res);

    }

    public function gettingLinks(array $links)
    {
        $this->links = $links;
    } 

    public function render()
    {
        return view('livewire.edit-profile');
    }
}
