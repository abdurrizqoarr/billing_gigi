<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PemberianObat extends Model
{
    use HasUuids;

    protected $table = 'pemberian_obat_bhp';

    protected $fillable = [
        'pasien_id',
        'nama_obat',
        'harga',
        'obat_id'
    ];
}
