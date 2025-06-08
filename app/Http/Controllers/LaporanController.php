<?php

namespace App\Http\Controllers;
use App\Models\Kendaraan;
use App\Models\Pemakaian;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use App\Exports\LaporanKeluarExport;
use PDF;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function laporan_masuk()
    {
        $pageTitle = 'Laporan Masuk';
        $laporan_masuk = Kendaraan::where('hapus_id', 0)->get();
        return view('laporan.laporan_masuk', compact('pageTitle', 'laporan_masuk'));

    }

    public function laporan_keluar()
    {
        $pageTitle = 'Laporan Keluar';
        $laporan_keluar = Pemakaian::with('kendaraan')
            ->whereHas('kendaraan', function ($query) {
                $query->where('hapus_id', 0);
            })
            ->orderByRaw('CASE WHEN jam_kembali IS NULL THEN 0 ELSE 1 END')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('laporan.laporan_keluar', compact('pageTitle', 'laporan_keluar'));

    }

    public function exportExcel()
    {
        return Excel::download(new LaporanExport, 'laporan_servis.xlsx');
    }

    public function exportExcelKeluar()
    {
        return Excel::download(new LaporanKeluarExport, 'laporan_pemakaian.xlsx');
    }


    public function exportPdf()
    {
        $laporan_masuk = Kendaraan::where('hapus_id', 0)->get();
        $pdf = PDF::loadView('servis.export_pdf_masuk', compact('laporan_masuk'));
        return $pdf->download('laporan_servis.pdf');
    }

    public function exportPdfKeluar()
    {
        $laporan_keluar = Pemakaian::with('kendaraan')
            ->whereHas('kendaraan', function ($query) {
                $query->where('hapus_id', 0);
            })
            ->orderByRaw('CASE WHEN jam_kembali IS NULL THEN 0 ELSE 1 END')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = PDF::loadView('servis.export_pdf_keluar', compact('laporan_keluar'));
        return $pdf->download('laporan_pemakaian.pdf');
    }


}
