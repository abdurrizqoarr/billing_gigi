<div class="p-6 space-y-6">

    <!-- Header -->
    @auth('pegawai')
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Data Pasien</h1>

            <div class="flex items-center gap-3">
                @if (auth('pegawai')->user()->role === 'DOKTER')
                    <a href="{{ route('billing-page') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                        Daftarkan Pasien Baru
                    </a>
                @endif

                <!-- Tombol Logout -->
                <button wire:click="logout" wire:confirm="Keluar dari aplikasi?"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
                    Logout
                </button>
            </div>
        </div>
    @endauth

    <!-- Filter -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
        <!-- Search -->
        <div class="col-span-1 md:col-span-2">
            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari nama pasien..."
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <!-- Date Range -->
        <div>
            <input type="date" wire:model="startDate"
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
        </div>
        <div>
            <input type="date" wire:model="endDate"
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <button wire:click="applyFilter"
                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                Cari
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Tanggal Daftar</th>
                    <th class="px-4 py-3 text-left">Total Bayar</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($pasiens as $index => $pasien)
                    <tr>
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $pasien->nama_pasien }}</td>
                        <td class="px-4 py-3">{{ $pasien->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">
                            Rp {{ number_format($pasien->total_biaya, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3">{{ $pasien->status_bayar }}</td>
                        <td class="px-4 py-3 space-x-2">
                            @if ($pasien->status_bayar === 'BELUM BAYAR')
                                @auth('pegawai')
                                    @if (auth('pegawai')->user()->role === 'DOKTER')
                                        <a href="{{ route('pasien.edit', $pasien->id) }}"
                                            class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                            Edit
                                        </a>
                                    @endif
                                @endauth

                                <a href="{{ route('pembayaran', $pasien->id) }}"
                                    class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    Bayar
                                </a>
                            @endif

                            @if ($pasien->status_bayar === 'SUDAH BAYAR')
                                <a href="{{ route('pasien.cetak', $pasien->id) }}" target="_blank"
                                    class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Cetak
                                </a>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            Tidak ada data pasien.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
