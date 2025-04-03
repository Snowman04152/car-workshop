<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\ServisController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\HomeController;

Auth::routes();
Route::get('/', function () {
    return view('welcome');
});
=======

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard.dashboard');
// })->name('dashboard');

// Route::get('/login', function () {
//     return view('login.login');
// })->name('login');

Route::get('/jenis', [MasterDataController::class, 'jenis'])->name('jenis');
Route::post('/add_jenis', [MasterDataController::class, 'add_jenis'])->name('jenis.add');
Route::put('/jenis/edit/{id}', [MasterDataController::class, 'edit_jenis'])->name('jenis.edit');


Route::get('/merk', [MasterDataController::class, 'merk'])->name('merk');
Route::post('/add_merk', [MasterDataController::class, 'add_merk'])->name('merk.add');
Route::put('/merk/edit/{id}', [MasterDataController::class, 'edit_merk'])->name('merk.edit');

Route::get('/kendaraan', [MasterDataController::class, 'kendaraan'])->name('kendaraan');
Route::post('/add_kendaraan', [MasterDataController::class, 'add_kendaraan'])->name('kendaraan.add');
Route::put('/kendaraan/edit/{id}', [MasterDataController::class, 'edit_kendaraan'])->name('kendaraan.edit');
Route::put('/kendaraan/delete/{id}', [MasterDataController::class, 'hapus_kendaraan'])->name('kendaraan.hapus');


Route::get('/servis', [ServisController::class, 'servis'])->name('servis');
Route::post('/add_servis', [ServisController::class, 'add_servis'])->name('servis.add');
Route::put('/servis/edit/{id}', [ServisController::class, 'edit_servis'])->name('servis.edit');
Route::put('/servis/delete/{id}', [ServisController::class, 'hapus_servis'])->name('servis.hapus');

Route::get('/laporanmasuk', [LaporanController::class, 'laporan_masuk'])->name('laporan_masuk');
Route::get('exportExcel', [LaporanController::class, 'exportExcel'])->name('laporanmasuk.exportExcel');
Route::get('exportPdf', [LaporanController::class, 'exportPdf'])->name('laporanmasuk.exportPdf');

Route::get('/laporankeluar', [LaporanController::class, 'laporan_keluar'])->name('laporan_keluar');
Route::get('exportExcelKeluar', [LaporanController::class, 'exportExcelKeluar'])->name('laporankeluar.exportExcel');
Route::get('exportPdfKeluar', [LaporanController::class, 'exportPdfKeluar'])->name('laporankeluar.exportPdf');


Route::get('/public-disk', function () {
    Storage::disk('public');
    Route::get('/retrieve-public-file', function () {
        if (Storage::disk('public')) {
            $contents = Storage::disk('public');
        } else {
            $contents = 'File does not exist';
        }
        return $contents;
    });
});



Route::get('/selesaiservis', action: function () {
    return view('servis.selesai_servis');
})->name('selesaiservis');

Route::get('/pemeliharaan', action: function () {
    return view('pemeliharaan.pemeliharaan');
})->name('pemeliharaan');

Route::get('/role', action: function () {
    return view('settings.role');
})->name('role');

Route::get('/list', action: function () {
    return view('settings.list');
})->name('list');




>>>>>>> Stashed changes
