<?php

namespace App\Http\Controllers;
use App\Models\Pemeliharaan;
use App\Models\Servis;

use Illuminate\Http\Request;

class PemeliharaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pemeliharaan()
    {
        $pageTitle = 'Pemeliharaan';
        $pemeliharaan = Pemeliharaan::with([
            'servis.kendaraan.jenis',
            'servis.kendaraan.merk'
        ])->where('hapus_id', 0)->get();
        
        $servis = Servis::with(['kendaraan', 'kendaraan.jenis', 'kendaraan.merk'])->where('hapus_id', 0)->get();
        return view('pemeliharaan.pemeliharaan', compact('pageTitle', 'pemeliharaan','servis'));
    }
}
