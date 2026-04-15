<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $fillable = ['id_pelanggan', 'detail', 'total_harga'];

    public $timestamps = true;
}

