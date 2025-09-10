<?php

namespace App\Livewire\Wizard;

use Livewire\Component;

class BiodataPasien extends Component
{
    public $nama_pasien, $no_rm;

    public function simpan()
    {
        $this->dispatch('updateBiodata', [
            'nama_pasien' => $this->nama_pasien,
            'no_rm'       => $this->no_rm,
        ]);
    }

    public function render()
    {
        return view('livewire.wizard.biodata-pasien');
    }
}
