<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class Countdown extends Component
{
    public $counter = 100;

    public function decrement()
    {
        $this->counter--;
    }

    public function render()
    {
        return view('livewire.countdown');
    }
}
