<?php

namespace App\Livewire\Wizard;

use App\Models\ObatBhp;
use Livewire\Component;
use Illuminate\Support\Str;

class Bhp extends Component
{
    public $search = '';
    public $dataList = [];
    public $dataTerpilih = [];
    public $total = 0;

    protected $listeners = ['listenRefreshObat'];

    public function terapkan($id)
    {
        $data = ObatBhp::find($id);

        if (!$data) return;
        $this->dispatch('addObat', [
            'id' => (string) Str::uuid(),
            'id_obat' => $data->id,
            'nama_obat' => $data->nama_obat,
            'harga' => $data->harga,
        ]);
    }

    public function batal($id)
    {
        $this->dispatch('hapusObat', [
            'id' => $id,
        ]);
    }

    public function listenRefreshObat($data)
    {
        $this->dataTerpilih = $data['data'];
        $this->total = $data['total'];
    }

    public function render()
    {
        $this->dataList = ObatBhp::query()
            ->when($this->search, fn($q) => $q->where('nama_obat', 'like', '%' . $this->search . '%'))
            ->orderBy('nama_obat')
            ->get();

        return view('livewire.wizard.bhp');
    }
}
