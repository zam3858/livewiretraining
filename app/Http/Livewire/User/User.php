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

    protected $rules = ['name' => ['required', 'min:3']];

    public function saveUser()
    {
        if (empty($this->user_id)) {
            $this->validate(
                array_merge(
                    $this->rules,
                    [
                        'email' => ['email', 'unique:users'],
                        'password' => ['required']
                    ]
                )
            );
            $user = new Pengguna();
        } else {
            $this->validate(
                array_merge(
                    $this->rules,
                    ['email' => ['email', Rule::unique('users')->ignore($this->user_id)]]
                )
            );
            $user = Pengguna::find($this->user_id);
        }

        $user->name = $this->name;
        $user->email = $this->email;

        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        if ($this->photo) {
            $user->photos = $this->photo->store('photos', 'public');
        }

        $user->save();

        $this->resetUser();

        session()->flash('alert_message', "Berjaya simpan");
    }

    public function edit($user_id)
    {
        $user = Pengguna::find($user_id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->photo = '';
    }

    public function show($user_id)
    {
        $user = Pengguna::find($user_id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->photo = $user->photos;
    }

    public function delete($user_id)
    {
        $user = Pengguna::find($user_id);
        $user->delete();
    }

    public function resetUser()
    {
        $this->user_id = '';
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->photo = '';
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
