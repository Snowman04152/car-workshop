<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemeliharaan extends Model
{
    use HasFactory;

    public function Servis()
    {
        return $this->belongsTo( Servis::class, 'servis_id', 'id');
    }
}
