<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders'; // Sesuaikan nama tabel
    protected $fillable = [
        'id_pelanggan',
        'total_harga',
        // kolom lain jika ada
    ];

    // Relasi ke detail order
    public function details()
    {
        return $this->hasMany(DetailOrder::class, 'order_id');
    }
}