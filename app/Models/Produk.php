<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Sesuaikan dengan nama tabel di database

    protected $fillable = [
        'nama',
        'kategori',
        'harga',
        'stok',
        'gambar'
    ];
}