<x-filament-panels::page>
    <h1 class="text-xl font-bold">
        Total Transaksi: Rp {{ number_format($this->totalPendapatan, 0, ',', '.') }}
    </h1>

    {{ $this->table }}
</x-filament-panels::page>
