<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PemberianBiayaLain extends Model
{
    use HasUuids;

    protected $table = 'pemberian_biaya_lain';

    protected $fillable = [
        'pasien_id',
        'biaya_lainnya',
        'harga'
    ];
}
