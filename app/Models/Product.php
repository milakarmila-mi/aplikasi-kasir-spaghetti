<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'nama',
        'harga',
        'gambar'
    ];

    public $timestamps = false;
}