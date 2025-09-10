<?php

namespace App\Livewire;

use App\Events\PasienUpdate;
use App\Models\AkunPenerimaan;
use App\Models\PemberianTindakan;
use App\Models\RegistrasiPasien;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PembayaranPage extends Component
{
    public $pasien;
    public $pemberianTindakan = [], $pemberianObat = [];
    public $akunPenerimaan;
    public $selectedAkunPenerimaan, $nominalPembayaran, $kembalian = 0;
    public $errorMessage;

    public function mount($id)
    {
        $this->pasien = RegistrasiPasien::with(['biayaLain', 'diskon', 'tindakans', 'obatBhp'])->findOrFail($id);
        $this->akunPenerimaan = AkunPenerimaan::get();

        $hasil = [];

        foreach ($this->pasien->tindakans as $item) {
            $key = $item->tarif_tindakan . '-' . $item->nilai_tarif;

            if (!isset($hasil[$key])) {
                $hasil[$key] = [
                    'tarif_tindakan' => $item->tarif_tindakan,
                    'nilai_tarif'    => $item->nilai_tarif,
                    'jumlah'         => 0,
                    'total'          => 0,
                ];
            }

            $hasil[$key]['jumlah']++;
            $hasil[$key]['total'] += $item->nilai_tarif;
        }

        $this->pemberianTindakan = array_values($hasil);

        $hasil = [];

        foreach ($this->pasien->obatBhp as $item) {
            $key = $item->nama_obat . '-' . $item->harga;

            if (!isset($hasil[$key])) {
                $hasil[$key] = [
                    'nama_obat' => $item->nama_obat,
                    'harga'    => $item->harga,
                    'jumlah'         => 0,
                    'total'          => 0,
                ];
            }

            $hasil[$key]['jumlah']++;
            $hasil[$key]['total'] += $item->harga;
        }
        $this->pemberianObat = array_values($hasil);
    }

    public function updatedNominalPembayaran()
    {
        $this->kembalian = (float) $this->nominalPembayaran - $this->pasien->total_biaya;
    }

    protected function rules()
    {
        return [
            'nominalPembayaran' => 'required|numeric|min:' . $this->pasien->total_biaya,
            'selectedAkunPenerimaan' => 'required|exists:akun_penerimaan,id',
        ];
    }

    protected function messages()
    {
        return [
            'nominalPembayaran.required' => 'Nominal pembayaran wajib diisi.',
            'nominalPembayaran.numeric' => 'Nominal pembayaran harus berupa angka.',
            'nominalPembayaran.min' => 'Nominal pembayaran tidak boleh kurang dari total tagihan.',
            'selectedAkunPenerimaan.required' => 'Pilih akun penerimaan.',
            'selectedAkunPenerimaan.exists' => 'Akun penerimaan yang dipilih tidak valid.',
        ];
    }

    public function handlePembayaran($id)
    {
        $validate = $this->validate();
        // Menggunakan transaksi database untuk memastikan kedua operasi berhasil
        $this->errorMessage = null;
        DB::beginTransaction();

        try {
            // 1. Ambil data pasien. Menggunakan findOrFail akan otomatis menangani kasus ID tidak ditemukan.
            $pasien = RegistrasiPasien::findOrFail($id);

            // 2. Perbarui status pembayaran
            $pasien->status_bayar = 'SUDAH BAYAR';
            $pasien->save();

            // 3. Buat entri riwayat transaksi baru
            RiwayatTransaksi::create([
                'pegawai' => Auth::guard('pegawai')->id(),
                'akun_penerimaan_id' => $validate['selectedAkunPenerimaan'],
                'registrasi_id' => $id,
                'waktu_transaksi' => now(),
            ]);

            DB::commit();
            event(new PasienUpdate());

            return redirect()->route('dashboard-page');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorMessage = 'Terjadi kesalahan saat menyelesaikan pembayaran. Silakan coba lagi. ' . $e->getMessage();

            Log::channel('registrasi_error')->error('Gagal Menyelesaikan Pembayaran', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $this->all() ?? [],
            ]);
        }
    }


    public function render()
    {
        return view('livewire.pembayaran-page');
    }
}
