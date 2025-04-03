<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    use HasFactory;
    public function kendaraan()
    {
        return $this->hasMany(Merk::class, 'id_merk', 'id');
    }
}
