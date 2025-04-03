<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    use HasFactory;

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_keluar' => 'datetime'
    ];
    
    public function getTanggalMasukFormattedAttribute()
{
    return $this->tanggal_masuk->format('d M'); // Contoh: 25 Jul
}
    public function kendaraan()
    {
        return $this->belongsTo( Kendaraan::class, 'kendaraan_id', 'id');
    }
}
