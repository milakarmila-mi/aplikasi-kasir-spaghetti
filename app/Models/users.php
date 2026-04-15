<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';  // Nama tabel manual

    protected $fillable = [
        'email', 'password'
    ];

    public $timestamps = false; // Kalau tabel kamu gak punya kolom created_at/updated_at

    // Nonaktifkan mass assignment guard jika perlu
    // protected $guarded = [];

    // Jika kolom id bukan auto increment atau pakai key lain, atur di sini
    // protected $primaryKey = 'id';
    // public $incrementing = true;
}
