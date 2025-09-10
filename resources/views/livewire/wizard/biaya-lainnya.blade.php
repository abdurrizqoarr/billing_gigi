<div class="w-full grid grid-cols-2 gap-6">
    <!-- Panel Kiri : Form Input -->
    <div class="bg-white rounded-2xl shadow-md p-5 flex flex-col max-h-[28rem]">
        <!-- Input Biaya Lainnya -->
        <div class="mb-3">
            <input type="text" name="biaya_lainnya" id="biaya_lainnya" wire:model="biaya_lainnya"
                class="w-full bg-white border @error('biaya_lainnya') border-red-400 @else border-sky-300 @enderror 
                   rounded-2xl px-4 py-2 shadow-sm 
                   focus:outline-none focus:ring-2 @error('biaya_lainnya') focus:ring-red-400 focus:border-red-400 @else focus:ring-sky-400 focus:border-sky-400 @enderror
                   transition duration-200 ease-in-out"
                placeholder="Nama Biaya Lainnya">
            @error('biaya_lainnya')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Harga -->
        <div class="mb-3">
            <input type="number" name="harga" id="harga" wire:model="harga"
                class="w-full bg-white border @error('harga') border-red-400 @else border-sky-300 @enderror 
                   rounded-2xl px-4 py-2 shadow-sm 
                   focus:outline-none focus:ring-2 @error('harga') focus:ring-red-400 focus:border-red-400 @else focus:ring-sky-400 focus:border-sky-400 @enderror
                   transition duration-200 ease-in-out"
                placeholder="Harga">
            @error('harga')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Simpan -->
        <button wire:click="terapkan"
            class="w-full bg-sky-500 text-white py-2 rounded-2xl shadow-md 
               hover:bg-sky-600 transition duration-200 ease-in-out">
            Simpan
        </button>
    </div>


    <!-- Panel Kanan : List Data -->
    <div class="bg-white rounded-2xl shadow-md p-5 flex flex-col max-h-[28rem]">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Biaya Lainnya</h3>

        <div class="flex-1 overflow-y-auto space-y-2">
            @forelse($listBiayaLainnya as $item)
                <div
                    class="flex justify-between items-center p-3 bg-sky-50 
                           rounded-xl border border-sky-200">
                    <div>
                        <p class="font-medium text-gray-700">{{ $item['biaya_lainnya'] }}</p>
                        <p class="text-sm text-gray-500">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                    </div>
                    <button wire:click="batal('{{ $item['id'] }}')"
                        class="px-3 py-1 bg-red-500 text-white text-sm rounded-xl shadow 
                               hover:bg-red-600 transition">
                        Hapus
                    </button>
                </div>
            @empty
                <p class="text-gray-500 italic">Belum ada data.</p>
            @endforelse
        </div>

        <!-- Total -->
        <div class="border-t mt-3 pt-3 flex justify-between font-semibold text-gray-700">
            <span>Total</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
