<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PemberianDiskon extends Model
{
    use HasUuids;

    protected $table = 'pemberian_diskon';

    protected $fillable = [
        'pasien_id',
        'diskon',
        'harga'
    ];
}
