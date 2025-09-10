<?php

namespace App\Livewire;

use App\Models\RegistrasiPasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class DashboardPage extends Component
{
    public $search = '';
    public $startDate;
    public $endDate;
    public $pasiens;

    public function mount()
    {
        // default range: hari ini
        $today = Carbon::today()->toDateString();
        $this->startDate = $today;
        $this->endDate = $today;
        $this->getData();
    }

    #[On('echo:pasien-update,PasienUpdate')]
    public function refreshData()
    {
        $this->getData();
    }

    public function logout()
    {
        Auth::guard('pegawai')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login-page');
    }

    public function getData()
    {
        $this->pasiens = RegistrasiPasien::query()
            ->when(
                $this->search,
                fn($q) =>
                $q->where('nama_pasien', 'like', '%' . $this->search . '%')
            )
            ->when(
                $this->startDate && $this->endDate,
                fn($q) =>
                $q->whereBetween('created_at', [
                    Carbon::parse($this->startDate)->startOfDay(),
                    Carbon::parse($this->endDate)->endOfDay()
                ])
            )
            ->latest()
            ->get();
    }

    public function updatedSearch()
    {
        $this->getData();
    }

    public function applyFilter()
    {
        $this->getData();
    }

    public function render()
    {
        return view('livewire.dashboard-page',);
    }
}
