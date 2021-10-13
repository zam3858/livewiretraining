<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Zakat extends Component
{
    public $kadarZakat = 2.5;
    public $jumlahPendapatan=0;
    public $hasilKiraanZakat = 0;
    public $statusKiraan = "Kiraan baru";
    public $showDetail = false;

    public function kiraZakat()
    {
        $this->hasilKiraanZakat = $this->jumlahPendapatan * ($this->kadarZakat/100);
        $this->statusKiraan = "Kiraan Selesai";
    }

    public function resetJumlahPendapatan()
    {
        $this->jumlahPendapatan = 0;
    }

    public function toggleDetail()
    {
        if($this->showDetail) {
            $this->showDetail = false;
        } else {
            $this->showDetail = true;
        }
    }

    public function render()
    {
        $nama = "Abdul";
        $age = 40;
        $kerja = "Secretariat";
        return view('livewire.zakat', compact('nama', 'age','kerja'));
    }
}
