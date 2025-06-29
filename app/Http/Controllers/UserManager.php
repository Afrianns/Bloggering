<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class UserManager extends Controller
{
    public function register() {
        return view("components.auth.register");
    }

    public function login() {
        return view("components.auth.login");
    }
    
    public function registerPost(Request $request) {
        
        $validated = $request->validate([
            "name" => "required|min:5",
            "email" => "required|min:5|unique:users|email:dns.rfc",
            "password" => "required|min:5|confirmed:repeat_password",
            "repeat_password" => "required|min:5"
        ]);
        
        User::create($validated);

        if (Auth::attempt([ "email" => $validated['email'], "password" => $validated['password']])) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
    }

    public function loginPost(Request $request) {

        $validated = $request->validate([
            "email" => "required|min:5|email:dns.rfc",
            "password" => "required|min:5"
        ]);

        if (Auth::attempt($validated)){
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        } 

        return redirect('login')->with("message", "User not found! Make sure credentials are match");

    }

    public function logoutPost(Request $request) {
        Auth::logout();
        
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
