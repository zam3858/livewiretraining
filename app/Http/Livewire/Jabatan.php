<?php

namespace App\Http\Livewire;

use App\Models\Jabatan as Department;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Jabatan extends Component
{
    // trait
    use WithPagination;

    //public $jabatans;
    public $jabatan_id = '';
    public $name = '';
    public $code = '';

    protected $rules = ['name' => ['required', 'min:3']];

    public function saveJabatan()
    {
        if(empty($this->jabatan_id)) {
            $this->validate(
                array_merge(
                    $this->rules,
                    [
                        'code' => ['required', 'unique:departments'],
                    ]
                )
            );
            $jabatan = new Department();
        } else {
            $this->validate(
                array_merge(
                    $this->rules,
                    ['code' => ['required', Rule::unique('departments')->ignore($this->jabatan_id)]]
                )
            );
            $jabatan = Department::find($this->jabatan_id);
        }

        $jabatan->name = $this->name;
        $jabatan->code = $this->code;

        $jabatan->save();

        $this->resetJabatan();

        session()->flash('alert_message', "Berjaya simpan");
    }

    public function edit($jabatan_id)
    {
        $jabatan = Department::find($jabatan_id);
        $this->jabatan_id = $jabatan->id;
        $this->name = $jabatan->name;
        $this->code = $jabatan->code;
    }

    public function delete($jabatan_id)
    {
        $jabatan = Department::find($jabatan_id);
        $jabatan->delete();
    }

    public function resetJabatan()
    {
        $this->jabatan_id = '';
        $this->name = '';
        $this->code = '';
    }

    public function render()
    {
        return view('livewire.jabatan', [
            'jabatans' => Department::orderBy('name', 'ASC')->paginate(5)
        ])
            ->extends('layouts.app');
    }
}
