<?php

use App\Http\Controllers\Login;
use App\Http\Controllers\Register;
use App\Http\Controllers\UserManager;
use App\Livewire\AddNewArticle;
use App\Livewire\Detail;
use App\Livewire\EditArticle;
use App\Livewire\EditProfile;
use App\Livewire\Explore;
use App\Livewire\Home;
use App\Livewire\Profile;
use Illuminate\Support\Facades\Route;

Route::get("/", function() {
    return redirect("login");
});

Route::middleware("guest")->group(function() {
    Route::post('/login', [UserManager::class, 'loginPost'])->name('login-post');
    Route::get('/login', [UserManager::class, 'login'])->name("login");
    
    Route::post('/register', [UserManager::class, 'registerPost'])->name('register-post');
    Route::get('register', [UserManager::class, 'register'])->name('register');
});

Route::middleware("auth")->group(function () {

    Route::post("/logout", [UserManager::class, 'logoutPost'])->name("logout");
    
    Route::get('/dashboard', Home::class);
    Route::get('/dashboard/detail/{uuid}', Detail::class);

    Route::get('/dashboard/detail/user/{uuid}', Profile::class);

    Route::get('/dashboard/detail/edit/{uuid}', EditArticle::class);
    Route::get('/article/add', AddNewArticle::class);
    Route::get('/explore', Explore::class);

    // Profile Section
    Route::get('/profile/{uuid}', Profile::class);
    Route::get("/profile/edit/{uuid}", EditProfile::class);
    
})->middleware("auth");