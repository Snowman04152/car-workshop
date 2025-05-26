<?php

namespace App\Http\Controllers;
use App\Models\Kendaraan;
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
        $kendaraan = Kendaraan::where('hapus_id', 0)->get();
        return view('pemeliharaan.pemeliharaan', compact('pageTitle', 'kendaraan'));
    }
}
