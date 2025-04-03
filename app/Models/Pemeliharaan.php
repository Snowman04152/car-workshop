<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemeliharaan extends Model
{
    use HasFactory;

    public function kendaraan()
    {
        return $this->belongsTo( Kendaraan::class, 'kendaraan_id', 'id');
    }
}
