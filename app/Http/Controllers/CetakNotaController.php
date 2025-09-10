<?php

namespace App\Http\Controllers;

use App\Models\RegistrasiPasien;
use Illuminate\Http\Request;

class CetakNotaController extends Controller
{
    public function cetak($id)
    {
        // ambil data pasien beserta relasi
        $pasien = RegistrasiPasien::with(['biayaLain', 'diskon', 'tindakans', 'obatBhp'])->findOrFail($id);

        // 🔹 olah data tindakan
        $hasilTindakan = [];
        foreach ($pasien->tindakans as $item) {
            $key = $item->tarif_tindakan . '-' . $item->nilai_tarif;

            if (!isset($hasilTindakan[$key])) {
                $hasilTindakan[$key] = [
                    'tarif_tindakan' => $item->tarif_tindakan,
                    'nilai_tarif'    => $item->nilai_tarif,
                    'jumlah'         => 0,
                    'total'          => 0,
                ];
            }

            $hasilTindakan[$key]['jumlah']++;
            $hasilTindakan[$key]['total'] += $item->nilai_tarif;
        }
        $pemberianTindakan = array_values($hasilTindakan);

        // 🔹 olah data obat/BHP
        $hasilObat = [];
        foreach ($pasien->obatBhp as $item) {
            $key = $item->nama_obat . '-' . $item->harga;

            if (!isset($hasilObat[$key])) {
                $hasilObat[$key] = [
                    'nama_obat' => $item->nama_obat,
                    'harga'     => $item->harga,
                    'jumlah'    => 0,
                    'total'     => 0,
                ];
            }

            $hasilObat[$key]['jumlah']++;
            $hasilObat[$key]['total'] += $item->harga;
        }
        $pemberianObat = array_values($hasilObat);

        // 🔹 kirim ke view
        return view('cetak-nota', [
            'pasien'            => $pasien,
            'pemberianTindakan' => $pemberianTindakan,
            'pemberianObat'     => $pemberianObat,
        ]);
    }
}
