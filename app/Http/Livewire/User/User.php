<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use \App\Models\User as Pengguna;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;

class User extends Component
{
    // trait
    use WithPagination;

    //public $users;
    public $user_id = '';
    public $name = '';
    public $email = '';
    public $password = '';

    protected $rules = ['name' => ['required', 'min:3']];

    public function saveUser()
    {
        if(empty($this->user_id)) {
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

        if(!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $this->resetUser();

        $this->updateUserList();

        session()->flash('alert_message', "Berjaya simpan");
    }

    public function edit($user_id)
    {
        $user = Pengguna::find($user_id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
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
    }

    public function render()
    {
        return view('livewire.user', [
            'users' => Pengguna::orderBy('name', 'ASC')->paginate(5)
        ])
            ->extends('layouts.app');
    }
}
