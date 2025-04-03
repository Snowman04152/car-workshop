<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kendaraan extends Model
{
    use HasFactory;

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'id_jenis', 'id');
    }
    public function merk()
    {
        return $this->belongsTo(Merk::class, 'id_merk', 'id');
    }
    public function alamat()
    {
        return $this->belongsTo(Merk::class, 'id_merk', 'id');
    }

    public function servis()
    {
        return $this->hasMany(Servis::class, 'kendaraan_id', 'id');
    }
}
