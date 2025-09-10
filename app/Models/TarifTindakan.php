<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarifTindakan extends Model
{
    use SoftDeletes;

    protected $table = 'tarif_tindakan';

    protected $fillable = [
        'tarif_tindakan',
        'nilai_tarif'
    ];
}
