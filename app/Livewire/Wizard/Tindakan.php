<?php

namespace App\Livewire\Wizard;

use App\Models\TarifTindakan;
use Livewire\Component;
use Illuminate\Support\Str;

class Tindakan extends Component
{
    public $search = '';
    public $tindakanList = [];
    public $tindakanTerpilih = [];
    public $total = 0;

    public $inputGigi = [];

    protected $listeners = ['listenRefresh'];

    public function terapkanTindakan($id)
    {
        $tindakan = TarifTindakan::find($id);
        if (!$tindakan) return;

        // Ambil nomor gigi dari array berdasarkan ID, jika kosong beri string kosong atau null
        $nomor = $this->inputGigi[$id] ?? '-';

        $this->dispatch('addTindakan', [
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'id_tindakan' => $tindakan->id,
            'tarif_tindakan' => $tindakan->tarif_tindakan,
            'nilai_tarif' => $tindakan->nilai_tarif,
            'nomer_gigi' => $nomor,
        ]);

        // Opsional: Reset input setelah ditambahkan
        $this->inputGigi[$id] = '';
    }

    public function batalTindakan($id)
    {
        $this->dispatch('hapusTindakan', [
            'id' => $id,
        ]);
    }

    public function listenRefresh($data)
    {
        $this->tindakanTerpilih = $data['data'];
        $this->total = $data['total'];
    }

    public function render()
    {
        $this->tindakanList = TarifTindakan::query()
            ->when($this->search, fn($q) => $q->where('tarif_tindakan', 'like', '%' . $this->search . '%'))
            ->orderBy('tarif_tindakan')
            ->get();


        return view('livewire.wizard.tindakan');
    }
}
