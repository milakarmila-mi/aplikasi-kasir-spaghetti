<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    protected $table = 'kasir';

    protected $fillable = [
        'username',
        'password'
    ];

    public $timestamps = false;
}