<div class="bg-slate-50 min-h-screen w-6xl mx-auto p-4 sm:p-8 space-y-8">

    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('dashboard-page') }}"
            class="inline-flex items-center px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 hover:text-slate-800 shadow-sm transition">
            <!-- Icon panah -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="w-full mx-auto">
        <h1 class="text-3xl font-bold text-slate-800">Menu Pembayaran Pasien</h1>
        </p>
    </div>

    <div class="w-full bg-white shadow-md rounded-xl p-4 border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-sm">No RM</p>
                <p class="font-semibold text-slate-800">{{ $pasien->no_rm }}</p>
            </div>
            <div>
                <p class="text-slate-500 text-sm">Nama Pasien</p>
                <p class="font-semibold text-slate-800">{{ $pasien->nama_pasien }}</p>
            </div>
            <div>
                <p class="text-slate-500 text-sm">Total Biaya</p>
                <p class="font-semibold text-emerald-600">Rp {{ number_format($pasien->total_biaya, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="w-full bg-white shadow-md rounded-xl p-4 border border-slate-200">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Tindakan Diterapkan</h3>
        <div class="flex-1 overflow-y-auto space-y-2">
            @forelse($pemberianTindakan as $item)
                <div
                    class="flex justify-between items-center p-3 bg-sky-50 
                            rounded-xl border border-sky-200">
                    <div>
                        <p class="font-medium text-gray-700">{{ $item['tarif_tindakan'] }}</p>
                        <p class="text-sm text-gray-500">Rp {{ number_format($item['nilai_tarif'], 0, ',', '.') }} x
                            {{ $item['jumlah'] }}</p>
                    </div>

                    <h3>Rp {{ number_format($item['total'], 0, ',', '.') }}</h3>
                </div>
            @empty
                <p class="text-gray-500 italic">Belum ada Data.</p>
            @endforelse
        </div>
    </div>

    <div class="w-full bg-white shadow-md rounded-xl p-4 border border-slate-200">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Obat BHP Digunakan</h3>
        <div class="flex-1 overflow-y-auto space-y-2">
            @forelse($pemberianObat as $item)
                <div
                    class="flex justify-between items-center p-3 bg-sky-50 
                            rounded-xl border border-sky-200">
                    <div>
                        <p class="font-medium text-gray-700">{{ $item['nama_obat'] }}</p>
                        <p class="text-sm text-gray-500">Rp {{ number_format($item['harga'], 0, ',', '.') }} x
                            {{ $item['jumlah'] }}</p>
                    </div>

                    <h3>Rp {{ number_format($item['total'], 0, ',', '.') }}</h3>
                </div>
            @empty
                <p class="text-gray-500 italic">Belum ada Data.</p>
            @endforelse
        </div>
    </div>

    <div class="w-full bg-white shadow-md rounded-xl p-4 border border-slate-200">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Biaya Lainnya</h3>
        <div class="flex-1 overflow-y-auto space-y-2">
            @forelse($pasien->biayaLain as $item)
                <div
                    class="flex justify-between items-center p-3 bg-sky-50 
                            rounded-xl border border-sky-200">
                    <div>
                        <p class="font-medium text-gray-700">{{ $item['biaya_lainnya'] }}</p>
                    </div>

                    <h3>Rp {{ number_format($item['harga'], 0, ',', '.') }} </h3>
                </div>
            @empty
                <p class="text-gray-500 italic">Belum ada Data.</p>
            @endforelse
        </div>
    </div>

    <div class="w-full bg-white shadow-md rounded-xl p-4 border border-slate-200">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Diskon</h3>
        <div class="flex-1 overflow-y-auto space-y-2">
            @forelse($pasien->diskon as $item)
                <div
                    class="flex justify-between items-center p-3 bg-sky-50 
                            rounded-xl border border-sky-200">
                    <div>
                        <p class="font-medium text-gray-700">{{ $item['diskon'] }}</p>
                    </div>

                    <h3>-Rp {{ number_format($item['harga'], 0, ',', '.') }} </h3>
                </div>
            @empty
                <p class="text-gray-500 italic">Belum ada Data.</p>
            @endforelse
        </div>
    </div>

    @if ($errorMessage)
        <div class="w-full bg-red-50 border border-red-200 text-red-700 shadow-md rounded-xl p-4 mb-4">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 mt-0.5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h4 class="font-semibold">Terjadi Kesalahan</h4>
                    <p class="text-sm">{{ $errorMessage }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="w-full bg-white shadow-md rounded-xl p-4 mb-40 border border-slate-200">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Pembayaran</h3>

        <div class="space-y-3">
            <div class="flex items-center gap-3">
                <label for="akunPenerimaan" class="w-40 text-gray-700 font-medium">Tagihan</label>
                <input type="number" name="nominalPembayaran" id="nominalPembayaran" disabled
                    value="{{ (float) $pasien->total_biaya }}"
                    class="flex-1 border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

            </div>

            <div class="flex items-center gap-3">
                <label for="akunPenerimaan" class="w-40 text-gray-700 font-medium">Akun Penerimaan</label>
                <select name="akunPenerimaan" id="akunPenerimaan" wire:model="selectedAkunPenerimaan"
                    class="flex-1 border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Pilih Akun Penerimaan</option>
                    @foreach ($akunPenerimaan as $item)
                        <option value="{{ $item->id }}">{{ $item->akun_penerimaan }}</option>
                    @endforeach
                </select>
            </div>
            @error('selectedAkunPenerimaan')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror


            <div class="flex items-center gap-3">
                <label for="nominalPembayaran" class="w-40 text-gray-700 font-medium">Nominal Pembayaran</label>
                <input type="number" name="nominalPembayaran" id="nominalPembayaran"
                    wire:model.live="nominalPembayaran"
                    class="flex-1 border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            @error('nominalPembayaran')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror

            <div class="flex items-center gap-3">
                <span class="w-40 text-gray-700 font-medium">Kembalian</span>
                <p class="flex-1 font-semibold text-emerald-600">Rp {{ number_format($kembalian, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-6 text-right">
            <button wire:confirm="Selesaikan Pembayaran? Pembayaran yang diselesaikan tidak dapat dikembalikan."
                wire:click="handlePembayaran('{{ $pasien->id }}')"
                class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-md shadow-emerald-200 transition">
                Selesaikan Pembayaran
            </button>
        </div>
    </div>
</div>
