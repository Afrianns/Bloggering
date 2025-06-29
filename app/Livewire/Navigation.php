<?php

namespace App\Livewire;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navigation extends Component
{   
    private $notifications;
    public function mount()
    {
        $this->notifications = Notification::where("user_id", Auth::user()->id)->get();
    }


    public function removeAllNotification()
    {
        Notification::where("user_id", Auth::user()->id)->delete();
    }

    public function render()
    {
        return view('livewire.navigation',[
            "notifications" => $this->notifications
        ]);
    }
}
