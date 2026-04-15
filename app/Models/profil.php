<?php

// app/Models/profil.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users'; // pastikan nama tabel benar
    protected $primaryKey = 'id'; // atau sesuaikan jika primary key kamu beda
    public $timestamps = false; // kalau tabel kamu tidak pakai created_at dan updated_at
}
