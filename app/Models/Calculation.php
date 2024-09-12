<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    // Menentukan kolom yang dapat diisi massal
    protected $fillable = ['name', 'school', 'age', 'address', 'phone', 'shape', 'dimensions', 'result'];

    // Jika Anda menggunakan timestamps, pastikan property ini ada
    public $timestamps = true; 
}
