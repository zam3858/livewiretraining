<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\UserController;
use \App\Http\Livewire\User\User;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/users', [UserController::class, 'index']);
Route::get('/users', User::class);


Route::middleware(['auth'])->group(function() {
    Route::get('/home', function() {
        return view('home');
    })->name('home');

    Route::get('/user/profile', function() {
        return view('profile');
    })->name('profile');
});
