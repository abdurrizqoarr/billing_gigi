<?php

namespace App\Livewire;

use App\Models\PemberianBiayaLain;
use App\Models\PemberianDiskon;
use App\Models\PemberianObat;
use App\Models\PemberianTindakan;
use App\Models\RegistrasiPasien;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class EditBillingPasienPage extends Component
{
    public $errorMessage;
    public $successMessage;
    public $idRegister;

    public $nama_pasien, $no_rm;
    public $total_biaya = 0;

    public $tindakanTerpilih = [];
    public $biayaTindakan = 0;

    public $obatTerpilih = [];
    public $biayaObat = 0;

    public $lainnya = [];
    public $biayaLainnya = 0;

    public $diskon = [];
    public $biayaDIskon = 0;

    protected $listeners = ['updateBiodata', 'addTindakan', 'hapusTindakan', 'addObat', 'hapusObat', 'addBiayaLainnya', 'hapusBiayaLainnya', 'hapusDiskon', 'addDiskon'];

    public $step = 1;

    public $steps = [
        1 => 'Biodata Pasien',
        2 => 'Tindakan',
        3 => 'Obat BHP',
        4 => 'Biaya Lainnya',
        5 => 'Diskon & Potongan',
    ];

    public function goToStep($step)
    {
        $this->step = $step;
    }

    public function mount($id)
    {
        $this->idRegister = $id;
        $pasien = RegistrasiPasien::with(['tindakans', 'obatBhp', 'biayaLain', 'diskon'])->findOrFail($id);

        $this->nama_pasien   = $pasien->nama_pasien;
        $this->no_rm         = $pasien->no_rm;
        $this->total_biaya   = $pasien->total_biaya;

        foreach ($pasien->tindakans as $item) {
            $this->biayaTindakan += $item->nilai_tarif;
        }

        foreach ($pasien->obatBhp as $item) {
            $this->biayaObat += $item->harga;
        }

        foreach ($pasien->biayaLain as $item) {
            $this->biayaLainnya += $item->harga;
        }

        foreach ($pasien->diskon as $item) {
            $this->biayaDIskon += $item->harga;
        }

        // konversi ke array supaya konsisten dengan addTindakan(), addObat(), dll
        $this->tindakanTerpilih = $pasien->tindakans->map(function ($item) {
            return [
                'id'            => $item->id,
                'id_tindakan'   => $item->tindakan_id,
                'tarif_tindakan' => $item->tarif_tindakan ?? null,
                'nilai_tarif'   => $item->nilai_tarif,
            ];
        })->toArray();

        $this->obatTerpilih = $pasien->obatBhp->map(function ($item) {
            return [
                'id'      => $item->id,
                'id_obat' => $item->obat_id,
                'nama_obat' => $item->nama_obat,
                'harga'   => $item->harga,
            ];
        })->toArray();

        $this->lainnya = $pasien->biayaLain->map(fn($item) => [
            'id'    => $item->id,
            'biaya_lainnya'  => $item->biaya_lainnya,
            'harga' => $item->harga,
        ])->toArray();

        $this->diskon = $pasien->diskon->map(fn($item) => [
            'id'    => $item->id,
            'diskon'  => $item->diskon,
            'harga' => $item->harga,
        ])->toArray();
    }

    public function nextStep()
    {
        if ($this->step === 1 && (!$this->nama_pasien || !$this->no_rm)) {
            return; // jangan lanjut kalau biodata belum lengkap
        }

        if ($this->step < count($this->steps)) {
            $this->step++;
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function updateBiodata($data)
    {
        $this->nama_pasien = $data['nama_pasien'];
        $this->no_rm       = $data['no_rm'];
    }

    public function addTindakan($data)
    {
        $this->tindakanTerpilih[] = [
            'id' => $data['id'],
            'id_tindakan' => $data['id_tindakan'],
            'tarif_tindakan' => $data['tarif_tindakan'],
            'nilai_tarif' => $data['nilai_tarif'],
        ];

        $this->total_biaya -= $this->biayaTindakan;

        $this->hitungTotalTindakan();

        $this->total_biaya += $this->biayaTindakan;

        $this->dispatch('listenRefresh', [
            'data' => $this->tindakanTerpilih,
            'total' => $this->biayaTindakan
        ]);
    }

    public function hapusTindakan($data)
    {
        $this->total_biaya -= $this->biayaTindakan;

        $this->tindakanTerpilih = collect($this->tindakanTerpilih)
            ->reject(fn($t) => $t['id'] == $data['id'])
            ->values()
            ->toArray();

        $this->hitungTotalTindakan();
        $this->total_biaya += $this->biayaTindakan;

        $this->dispatch('listenRefresh', [
            'data' => $this->tindakanTerpilih,
            'total' => $this->biayaTindakan
        ]);
    }

    private function hitungTotalTindakan()
    {
        $this->biayaTindakan = collect($this->tindakanTerpilih)->sum('nilai_tarif');
    }

    public function addObat($data)
    {
        $this->obatTerpilih[] = [
            'id' => $data['id'],
            'id_obat' => $data['id_obat'],
            'nama_obat' => $data['nama_obat'],
            'harga' => $data['harga'],
        ];

        $this->total_biaya -= $this->biayaObat;

        $this->hitungTotalObat();

        $this->total_biaya += $this->biayaObat;

        $this->dispatch('listenRefreshObat', [
            'data' => $this->obatTerpilih,
            'total' => $this->biayaObat
        ]);
    }

    public function hapusObat($data)
    {
        $this->total_biaya -= $this->biayaObat;

        $this->obatTerpilih = collect($this->obatTerpilih)
            ->reject(fn($t) => $t['id'] == $data['id'])
            ->values()
            ->toArray();

        $this->hitungTotalObat();
        $this->total_biaya += $this->biayaObat;

        $this->dispatch('listenRefreshObat', [
            'data' => $this->obatTerpilih,
            'total' => $this->biayaObat
        ]);
    }

    private function hitungTotalObat()
    {
        $this->biayaObat = collect($this->obatTerpilih)->sum('harga');
    }

    public function addBiayaLainnya($data)
    {
        $this->lainnya[] = [
            'id' => $data['id'],
            'biaya_lainnya' => $data['biaya_lainnya'],
            'harga' => $data['harga'],
        ];

        $this->total_biaya -= $this->biayaLainnya;

        $this->hitungTotalBiayaLainnya();

        $this->total_biaya += $this->biayaLainnya;

        $this->dispatch('listenRefreshBiayaLainnya', [
            'data' => $this->lainnya,
            'total' => $this->biayaLainnya
        ]);
    }

    public function hapusBiayaLainnya($data)
    {
        $this->total_biaya -= $this->biayaLainnya;

        $this->lainnya = collect($this->lainnya)
            ->reject(fn($t) => $t['id'] == $data['id'])
            ->values()
            ->toArray();

        $this->hitungTotalBiayaLainnya();
        $this->total_biaya += $this->biayaLainnya;

        $this->dispatch('listenRefreshBiayaLainnya', [
            'data' => $this->lainnya,
            'total' => $this->biayaLainnya
        ]);
    }

    private function hitungTotalBiayaLainnya()
    {
        $this->biayaLainnya = collect($this->lainnya)->sum('harga');
    }

    public function addDiskon($data)
    {
        $this->diskon[] = [
            'id' => $data['id'],
            'diskon' => $data['diskon'],
            'harga' => $data['harga'],
        ];

        $this->total_biaya += $this->biayaDIskon;

        $this->hitungTotalDiskon();

        $this->total_biaya -= $this->biayaDIskon;

        $this->dispatch('listenRefreshDiskon', [
            'data' => $this->diskon,
            'total' => $this->biayaDIskon
        ]);
    }

    public function hapusDiskon($data)
    {
        $this->total_biaya += $this->biayaDIskon;

        $this->diskon = collect($this->diskon)
            ->reject(fn($t) => $t['id'] == $data['id'])
            ->values()
            ->toArray();

        $this->hitungTotalDiskon();
        $this->total_biaya -= $this->biayaDIskon;

        $this->dispatch('listenRefreshDiskon', [
            'data' => $this->diskon,
            'total' => $this->biayaDIskon
        ]);
    }

    private function hitungTotalDiskon()
    {
        $this->biayaDIskon = collect($this->diskon)->sum('harga');
    }

    protected function rules()
    {
        return [
            'nama_pasien' => 'required|string',
            'no_rm' => 'required|string',
            'tindakanTerpilih' => 'array',
            'diskon' => 'array',
            'lainnya' => 'array',
            'obatTerpilih' => 'array',
            'tindakanTerpilih.*.id_tindakan' => 'exists:tarif_tindakan,id',
            'obatTerpilih.*.id_obat' => 'exists:obat_bhp,id',
        ];
    }

    protected function messages()
    {
        return [
            'nama_pasien.required' => 'Nama Pasien Wajib Di Isi.',
            'nama_pasien.string' => 'Nama Pasien Tidak Valid.',
            'no_rm.string' => 'Nomer RM Wajib Tidak Valid.',
            'no_rm.required' => 'Nomer RM Wajib Di Isi.',
            'tindakanTerpilih.*.id_tindakan.required' => 'Tindakan tidak boleh kosong.',
            'tindakanTerpilih.*.id_tindakan.exists'   => 'Tindakan yang dipilih tidak valid.',

            'obatTerpilih.*.id_obat.required' => 'Obat tidak boleh kosong.',
            'obatTerpilih.*.id_obat.exists'   => 'Obat yang dipilih tidak valid.',
        ];
    }

    public function prosesSimpan()
    {
        $data = $this->validate();
        try {
            DB::beginTransaction();
            $pasien = RegistrasiPasien::findOrFail($this->idRegister);

            $pasien->tindakans()->delete();
            $pasien->obatBhp()->delete();
            $pasien->biayaLain()->delete();
            $pasien->diskon()->delete();

            $totalTindakan = 0;
            $totalObat     = 0;
            $totalLainnya     = 0;
            $totalDiskon     = 0;

            $tindakanValid = [];
            $obatValid     = [];

            // 2. Ambil ulang data tindakan dari tabel TarifTindakan
            foreach ($data['tindakanTerpilih'] as $tindakan) {
                $model = \App\Models\TarifTindakan::find($tindakan['id_tindakan']);

                $tindakanValid[] = [
                    'id'              => (string) Str::uuid(),
                    'pasien_id'       => $pasien->id,
                    'tindakan_id'       => $model['id'],
                    'tarif_tindakan'  => $model->tarif_tindakan,
                    'nilai_tarif'     => $model->nilai_tarif,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];

                $totalTindakan += $model->nilai_tarif;
            }

            // 3. Ambil ulang data obat dari tabel ObatBhp
            foreach ($data['obatTerpilih'] as $obat) {
                $model = \App\Models\ObatBhp::find($obat['id_obat']);

                $obatValid[] = [
                    'id'          => (string) Str::uuid(),
                    'pasien_id'       => $pasien->id,
                    'obat_id'       => $model['id'],
                    'nama_obat'   => $model->nama_obat,
                    'harga' => $model->harga,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];

                $totalObat += $model->harga;
            }

            foreach ($this->lainnya as $index => $item) {
                $this->lainnya[$index]['pasien_id'] = $pasien->id;
                $this->lainnya[$index]['created_at'] = now();
                $this->lainnya[$index]['updated_at'] = now();
                $totalLainnya += $item['harga'];
            }

            foreach ($this->diskon as $index => $item) {
                $this->diskon[$index]['pasien_id'] = $pasien->id;
                $this->diskon[$index]['created_at'] = now();
                $this->diskon[$index]['updated_at'] = now();
                $totalDiskon += $item['harga'];
            }

            // 4. Hitung total keseluruhan
            $total = $totalTindakan + $totalObat + $totalLainnya - $totalDiskon;

            $pasien->update([
                'no_rm'        => $data['no_rm'],
                'nama_pasien'  => $data['nama_pasien'],
                'total_biaya'  => $total,
            ]);

            PemberianTindakan::insert($tindakanValid);
            PemberianObat::insert($obatValid);
            PemberianDiskon::insert($this->diskon);
            PemberianBiayaLain::insert($this->lainnya);
            DB::commit();
            $this->successMessage = "Data pasien berhasil disimpan.";
            $this->errorMessage = null;

            // redirect manual
            return redirect()->route('dashboard-page');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::channel('registrasi_error')->error('Gagal simpan registrasi pasien', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'input' => $this->all() ?? [],
            ]);

            $this->errorMessage = "Terjadi kesalahan. Mohon ulangi proses.";
            $this->successMessage = null;
        }
    }

    public function render()
    {
        return view('livewire.edit-billing-pasien-page');
    }
}
