<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use \App\Models\User as Pengguna;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class User extends Component
{
    // trait
    use WithPagination, WithFileUploads;

    //public $users;
    public $user_id = '';
    public $name = '';
    public $email = '';
    public $password = '';
    public $photo = '';
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'addUser' => '$refresh',
        'deletedUser' => '$refresh'
    ];

    public function show($user_id)
    {
        $user = Pengguna::find($user_id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->photo = $user->photos;
    }

    public function getPhoto($user_id)
    {
        $user = Pengguna::find($user_id);
        return response()->download(storage_path('app/' . $user->photos));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = Pengguna::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name', 'ASC')
            ->paginate(10);

        return view('livewire.user', [
                'users' => $users
            ])
            ->extends('layouts.app');
    }
}
