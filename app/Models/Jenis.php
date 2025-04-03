<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Jenis extends Model
{
    use HasFactory;
    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class, 'id_jenis', 'id');
    }
}

