<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RegistrasiPasien extends Model
{
    use HasUuids;

    protected $table = 'registrasi_pasien'; // tabel sesuai migration

    protected $primaryKey = 'id';
    public $incrementing = false; // karena pakai uuid
    protected $keyType = 'string';

    protected $fillable = [
        'no_rm',
        'nama_pasien',
        'tanggal_daftar',
        'status_bayar',
        'total_biaya',
    ];

    public function tindakans()
    {
        return $this->hasMany(PemberianTindakan::class, 'pasien_id');
    }

    public function obatBhp()
    {
        return $this->hasMany(PemberianObat::class, 'pasien_id');
    }

    public function biayaLain()
    {
        return $this->hasMany(PemberianBiayaLain::class, 'pasien_id');
    }

    public function diskon()
    {
        return $this->hasMany(PemberianDiskon::class, 'pasien_id');
    }
}
