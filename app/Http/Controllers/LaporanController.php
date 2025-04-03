<?php

namespace App\Http\Controllers;
use App\Models\Servis;
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
        $laporan_masuk = Servis::with(['kendaraan', 'kendaraan.jenis', 'kendaraan.merk'])->where('hapus_id', 0)->where('tanggal_selesai', null)->get();
        return view('laporan.laporan_masuk', compact('pageTitle', 'laporan_masuk'));

    }

    public function laporan_keluar()
    {
        $pageTitle = 'Laporan Keluar';
        $laporan_keluar = Servis::with(['kendaraan', 'kendaraan.jenis', 'kendaraan.merk'])->where('hapus_id', 0)->whereNot('tanggal_selesai', null)->get();
        return view('laporan.laporan_keluar', compact('pageTitle', 'laporan_keluar'));

    }

    public function exportExcel()
    {
        return Excel::download(new LaporanExport, 'laporan.xlsx');
    }

    public function exportExcelKeluar()
    {
        return Excel::download(new LaporanKeluarExport, 'laporan_keluar.xlsx');
    }


    public function exportPdf()
    {
        $laporan_keluar = Servis::with(['kendaraan', 'kendaraan.jenis', 'kendaraan.merk'])->where('hapus_id', 0)->where('tanggal_selesai', null)->get();
        $pdf = PDF::loadView('servis.export_pdf_masuk', compact('laporan_masuk'));
        return $pdf->download('laporan_masuk.pdf');
    }

    public function exportPdfKeluar()
    {
        $laporan_keluar = Servis::with(['kendaraan', 'kendaraan.jenis', 'kendaraan.merk'])->whereNot('tanggal_selesai', null)->where('hapus_id', 0)->get();
        $pdf = PDF::loadView('servis.export_pdf_keluar', compact('laporan_keluar'));
        return $pdf->download('laporan_keluar.pdf');
    }


}
