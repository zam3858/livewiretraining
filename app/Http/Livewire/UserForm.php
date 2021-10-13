<?php

namespace App\Http\Livewire;

use App\Models\User as Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserForm extends Component
{
    use WithFileUploads;
    // Component attributes
    public $user_id = '';
    public $name = '';
    public $email = '';
    public $password = '';
    public $photo = '';

    protected $listeners = [
        'editUser' => 'edit',
        'deleteUser' => 'delete',
    ];

    public function mount() {
        if($this->user_id) {
            $user = User::find($this->user_id);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = $user->password;
            $this->photo = $user->photo;
        }
    }

    public function render()
    {
        return view('livewire.user-form');
    }

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

        $this->emit('addUser', $user->id)->up();

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

    public function resetUser()
    {
        $this->user_id = '';
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->photo = '';
    }

    public function delete($user_id)
    {
        $user = Pengguna::find($user_id);
        $user->delete();

        session()->flash('alert_message', "Berjaya dibuang");
        
        $this->emit('deletedUser')->up();
    }
}
