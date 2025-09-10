<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RiwayatTransaksi extends Model
{
    use HasUuids;

    protected $table = 'riwayat_transaksi'; // tabel sesuai migration

    protected $primaryKey = 'id';
    public $incrementing = false; // karena pakai uuid
    protected $keyType = 'string';

    protected $fillable = [
        'pegawai',
        'registrasi_id',
        'waktu_transaksi',
        'akun_penerimaan_id'
    ];

    public function registrasi()
    {
        return $this->belongsTo(RegistrasiPasien::class, 'registrasi_id');
    }

        public function akunPenerimaan()
    {
        return $this->belongsTo(AkunPenerimaan::class, 'akun_penerimaan_id');
    }

    public function pegawais()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai');
    }
}
