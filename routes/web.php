<?php

use App\Http\Livewire\User\User;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

//Route::get('/users', [UserController::class, 'index']);
Route::get('/users', User::class);
Route::get('/jabatans', \App\Http\Livewire\Jabatan::class);


Route::middleware(['auth'])->group(function() {
    Route::get('/home', function() {
        return view('home');
    })->name('home');

    Route::get('/user/profile', function() {
        return view('profile');
    })->name('profile');
});
