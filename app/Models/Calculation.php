<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'school', 'age', 'address', 'phone', 'shape', 'dimensions'
    ];

    protected $casts = [
        'dimensions' => 'array'
    ];
}
