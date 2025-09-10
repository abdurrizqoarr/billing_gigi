<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObatBhp extends Model
{
    use SoftDeletes;

    protected $table = 'obat_bhp';

    protected $fillable = [
        'nama_obat',
        'harga'
    ];
}
