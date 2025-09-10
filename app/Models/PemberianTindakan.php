<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemberianTindakan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pemberian_tindakan';
    protected $fillable = ['pasien_id', 'tarif_tindakan', 'nilai_tarif', 'tindakan_id'];

    public function pasien()
    {
        return $this->belongsTo(RegistrasiPasien::class, 'pasien_id');
    }
}
