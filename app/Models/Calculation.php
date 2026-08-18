<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    // Menentukan kolom yang dapat diisi massal
    protected $fillable = [
        'name',
        'school',
        'age',
        'address',
        'phone',
        'bangun_datar',
        'bangun_ruang',
        'result',
        'shape',
        'dimensions',
    ];

    public $timestamps = true; 
}
