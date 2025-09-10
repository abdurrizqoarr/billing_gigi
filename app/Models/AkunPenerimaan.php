<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AkunPenerimaan extends Model
{
    use SoftDeletes;

    protected $table = 'akun_penerimaan';

    protected $fillable = [
        'akun_penerimaan'
    ];
}
