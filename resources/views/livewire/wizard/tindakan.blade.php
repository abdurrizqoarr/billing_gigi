<div class="w-full grid grid-cols-2 gap-6">
    <!-- Panel Kiri : List Tindakan -->
    <div class="bg-white rounded-2xl shadow-md p-4 flex flex-col h-[28rem] overflow-auto">
        <!-- Search Bar -->
        <form class="mb-4">
            <input wire:model.live.debounce.500ms="search" type="text" placeholder="Cari tindakan..."
                class="w-full px-4 py-2 border border-sky-300 rounded-xl 
                       focus:outline-none focus:ring-2 focus:ring-sky-400
                       transition duration-200 ease-in-out">
        </form>

        <!-- Daftar Tindakan -->
        <div class="flex-1 overflow-y-auto space-y-2">
            @foreach ($tindakanList as $tindakan)
                <div
                    class="flex justify-between items-center p-3 bg-gray-50 
                            rounded-xl hover:bg-sky-50 transition cursor-pointer">
                    <div>
                        <p class="font-medium text-gray-700">{{ $tindakan->tarif_tindakan }}</p>
                        <p class="text-sm text-gray-500">Rp {{ number_format($tindakan->nilai_tarif, 0, ',', '.') }}</p>
                    </div>
                    <button wire:click="terapkanTindakan('{{ $tindakan->id }}')"
                        class="px-3 py-1 bg-sky-500 text-white text-sm rounded-xl hover:bg-sky-600">
                        Terapkan
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Panel Kanan : Tindakan yang Diterapkan -->
    <div class="bg-white rounded-2xl shadow-md p-4 flex flex-col max-h-[28rem] overflow-auto">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Tindakan Diterapkan</h3>

        <div class="flex-1 overflow-y-auto space-y-2">
            @forelse($tindakanTerpilih as $item)
                <div
                    class="flex justify-between items-center p-3 bg-sky-50 
                            rounded-xl border border-sky-200">
                    <div>
                        <p class="font-medium text-gray-700">{{ $item['tarif_tindakan'] }}</p>
                        <p class="text-sm text-gray-500">Rp {{ number_format($item['nilai_tarif'], 0, ',', '.') }}</p>
                    </div>
                    <button wire:click="batalTindakan('{{ $item['id'] }}')"
                        class="px-3 py-1 bg-red-500 text-white text-sm rounded-xl hover:bg-red-600">
                        Hapus
                    </button>
                </div>
            @empty
                <p class="text-gray-500 italic">Belum ada tindakan diterapkan.</p>
            @endforelse
        </div>

        <!-- Total -->
        <div class="border-t mt-3 pt-3 flex justify-between font-semibold text-gray-700">
            <span>Total</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
