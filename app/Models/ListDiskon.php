<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListDiskon extends Model
{
    use SoftDeletes;

    protected $table = 'list_diskon';

    protected $fillable = [
        'diskon',
        'nilai_diskon'
    ];
}
