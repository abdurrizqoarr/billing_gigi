<div class="bg-slate-50 min-h-screen p-4 sm:p-8 space-y-8">

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
        <h1 class="text-3xl font-bold text-slate-800">Registrasi Pasien</h1>
        {{-- Menggunakan $steps[$step] karena array Anda 1-indexed --}}
        <p class="text-slate-500 mt-1">Langkah {{ $step }} dari {{ count($steps) }}: Mengisi {{ $steps[$step] }}
        </p>
    </div>

    {{-- Card Ringkasan Pasien --}}
    @if ($nama_pasien && $no_rm)
        <div class="w-full bg-white shadow-md rounded-xl p-4 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm">No RM</p>
                    <p class="font-semibold text-slate-800">{{ $no_rm }}</p>
                </div>
                <div>
                    <p class="text-slate-500 text-sm">Nama Pasien</p>
                    <p class="font-semibold text-slate-800">{{ $nama_pasien }}</p>
                </div>
                <div>
                    <p class="text-slate-500 text-sm">Total Biaya</p>
                    <p class="font-semibold text-emerald-600">Rp {{ number_format($total_biaya, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="w-full mx-auto">
        <div class="relative">
            <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-200 rounded-full"></div>
            <div class="absolute top-1/2 left-0 h-1 bg-indigo-600 rounded-full transition-all duration-500"
                style="width: {{ (($step - 1) / (count($steps) - 1)) * 100 }}%;">
            </div>

            <div class="flex items-center justify-between relative">
                {{-- Loop ini sekarang benar karena $index akan berisi 1, 2, 3, dst. --}}
                @foreach ($steps as $index => $label)
                    <button wire:click="goToStep({{ $index }})"
                        class="flex flex-col items-center space-y-2 focus:outline-none w-40">

                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300
                            {{ $step > $index ? 'bg-indigo-600' : '' }}
                            {{ $step === $index ? 'bg-indigo-600 ring-4 ring-indigo-200' : '' }}
                            {{ $step < $index ? 'bg-white border-2 border-slate-300' : '' }}">

                            @if ($step > $index)
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <span
                                    class="font-semibold
                                    {{ $step === $index ? 'text-white' : 'text-slate-500' }}">
                                    {{ $index }}
                                </span>
                            @endif
                        </div>

                        <span
                            class="text-xs sm:text-sm font-medium text-center
                            {{ $step >= $index ? 'text-indigo-700' : 'text-slate-400' }}">
                            {{ $label }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    @switch($step)
        @case(1)
            @livewire('wizard.biodata-pasien', ['nama_pasien' => $nama_pasien, 'no_rm' => $no_rm], key('step-1'))
        @break

        @case(2)
            @livewire('wizard.tindakan', ['tindakanTerpilih' => $tindakanTerpilih, 'total' => $biayaTindakan], key('step-2'))
        @break

        @case(3)
            @livewire('wizard.bhp', ['dataTerpilih' => $obatTerpilih, 'total' => $biayaObat], key('step-3'))
        @break

        @case(4)
            @livewire('wizard.biaya-lainnya', ['listBiayaLainnya' => $lainnya, 'total' => $biayaLainnya], key('step-4'))
        @break

        @case(5)
            @livewire('wizard.diskon-potongan', ['listDiskon' => $diskon, 'total' => $biayaDIskon], key('step-5'))
        @break
    @endswitch


    <div class="max-w-4xl mx-auto flex justify-between">
        <button wire:click="previousStep"
            class="px-5 py-2.5 cursor-pointerbg-white text-slate-700 font-semibold rounded-lg border border-slate-300 hover:bg-slate-100 transition disabled:opacity-50 disabled:cursor-not-allowed"
            @if ($step === 1) disabled @endif>
            Sebelumnya
        </button>
        <button wire:click="{{ $step === count($steps) ? 'prosesSimpan' : 'nextStep' }}"
            class="px-5 py-2.5 cursor-pointer
        {{ $step === count($steps)
            ? 'bg-green-600 hover:bg-green-700 shadow-green-200'
            : 'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-200' }}
        text-white font-semibold rounded-lg shadow-md transition
        disabled:opacity-50 disabled:cursor-not-allowed"
            @if ($step === 1 && (!$nama_pasien || !$no_rm)) disabled @endif>
            {{ $step === count($steps) ? 'Simpan' : 'Selanjutnya' }}
        </button>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
            <div class="p-4">
                <h2 class="font-semibold text-red-800 mb-2">Terjadi kesalahan:</h2>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if ($successMessage)
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl shadow-sm">
            <div class="p-4">
                <h2 class="font-semibold text-emerald-800 mb-2">Berhasil</h2>
                <p>{{ $successMessage }}</p>
            </div>
        </div>
    @endif

    @if ($errorMessage)
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
            <div class="p-4">
                <h2 class="font-semibold text-red-800 mb-2">Gagal</h2>
                <p>{{ $errorMessage }}</p>
            </div>
        </div>
    @endif
</div>
