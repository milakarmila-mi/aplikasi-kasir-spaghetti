<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $table = 'detail_pesanans'; // Sesuaikan nama tabel detail
    protected $fillable = [
        'order_id',
        'nama_menu',
        'jumlah',
        'harga',
    ];

    // Relasi balik ke order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}