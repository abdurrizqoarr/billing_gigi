<?php

namespace App\Livewire\Wizard;

use Illuminate\Support\Str;
use Livewire\Component;

class BiayaLainnya extends Component
{
    public $listBiayaLainnya = [];
    public $biaya_lainnya, $harga;
    public $total;

    protected $listeners = ['listenRefreshBiayaLainnya'];

    // Definisi aturan validasi
    protected function rules()
    {
        return [
            'biaya_lainnya' => ['required', 'string', 'min:5'],
            'harga'  => ['required', 'numeric', 'min:1'],
        ];
    }

    // Pesan error khusus
    protected function messages()
    {
        return [
            'biaya_lainnya.required' => 'Biaya Lainnya wajib diisi.',
            'biaya_lainnya.string'   => 'Biaya Lainnya harus berupa teks.',
            'biaya_lainnya.min'      => 'Biaya Lainnya minimal 5 karakter.',
            'harga.required'  => 'Harga wajib diisi.',
            'harga.numeric'   => 'Harga harus berupa angka.',
            'harga.min'       => 'Harga minimal Rp 1.',
        ];
    }

    public function terapkan()
    {
        $this->validate();

        $this->dispatch('addBiayaLainnya', [
            'id' => (string) Str::uuid(),
            'biaya_lainnya' => $this->biaya_lainnya,
            'harga' => $this->harga,
        ]);

        $this->reset(['biaya_lainnya', 'harga']);
    }

    public function batal($id)
    {
        $this->dispatch('hapusBiayaLainnya', [
            'id' => $id,
        ]);
    }

    public function listenRefreshBiayaLainnya($data)
    {
        $this->listBiayaLainnya = $data['data'];
        $this->total = $data['total'];
    }

    public function render()
    {
        return view('livewire.wizard.biaya-lainnya');
    }
}
