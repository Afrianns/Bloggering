<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function index() {
        return view("components.auth.login");
    }

    public function loginPost(Request $request) {

        $validated = $request->validate([
            "email" => "required|min:5|unique:users|email:dns.rfc",
            "password" => "required|min:5"
        ]);

        if (Auth::attempt($validated)){
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
    }


    public function logoutPost(Request $request) {
        Auth::logout();
        
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
