<div class="w-full space-y-4">
    <div class="flex gap-4 items-center justify-center">
        <!-- NO RM -->
        <input type="text" name="no_rm" id="no_rm" wire:model="no_rm"
            class="w-40 bg-white border border-sky-300 rounded-2xl px-4 py-2 shadow-sm 
                   focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400
                   transition duration-200 ease-in-out"
            placeholder="NO RM">

        <!-- NAMA PASIEN -->
        <input type="text" name="nama_pasien" id="nama_pasien" wire:model="nama_pasien"
            class="w-full bg-white border border-sky-300 rounded-2xl px-4 py-2 shadow-sm 
                   focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400
                   transition duration-200 ease-in-out"
            placeholder="NAMA PASIEN">
    </div>

    <!-- Tombol Simpan -->
    <div class="flex justify-end">
        <button wire:click="simpan"
            class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md shadow-indigo-200 
                   hover:bg-indigo-700 transition">
            Simpan
        </button>
    </div>
</div>
