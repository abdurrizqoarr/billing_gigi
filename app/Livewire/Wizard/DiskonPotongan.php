<?php

namespace App\Livewire\Wizard;

use Illuminate\Support\Str;
use Livewire\Component;

class DiskonPotongan extends Component
{
    public $listDiskon = [];
    public $diskon = '';
    public $harga = '';

    public $total;

    protected $listeners = ['listenRefreshDiskon'];

    // Definisi aturan validasi
    protected function rules()
    {
        return [
            'diskon' => ['required', 'string', 'min:5'],
            'harga'  => ['required', 'numeric', 'min:1'],
        ];
    }

    // Pesan error khusus
    protected function messages()
    {
        return [
            'diskon.required' => 'Diskon wajib diisi.',
            'diskon.string'   => 'Diskon harus berupa teks.',
            'diskon.min'      => 'Diskon minimal 5 karakter.',
            'harga.required'  => 'Harga wajib diisi.',
            'harga.numeric'   => 'Harga harus berupa angka.',
            'harga.min'       => 'Harga minimal Rp 1.',
        ];
    }

    public function terapkan()
    {
        $this->validate();

        $this->dispatch('addDiskon', [
            'id' => (string) Str::uuid(),
            'diskon' => $this->diskon,
            'harga' => $this->harga,
        ]);

        $this->reset(['diskon', 'harga']);
    }

    public function batal($id)
    {
        $this->dispatch('hapusDiskon', [
            'id' => $id,
        ]);
    }

    public function listenRefreshDiskon($data)
    {
        $this->listDiskon = $data['data'];
        $this->total = $data['total'];
    }

    public function render()
    {
        return view('livewire.wizard.diskon-potongan');
    }
}
