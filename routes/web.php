<?php
use App\Http\Controllers\PredictController;
use App\Http\Controllers\UserController;
use App\Models\Pemeliharaan;
use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\ServisController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\HomeController;
>>>>>>> Stashed changes

Route::get('/', function () {
    return view('welcome');
});
<<<<<<< Updated upstream
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



Route::get('/predict', [PredictController::class, 'predict']);
Route::get('/pemeliharaan', [PemeliharaanController::class, 'pemeliharaan'])->name('pemeliharaan');
Route::post('/pemeliharaan/store', [PredictController::class, 'store'])->name('pemeliharaan.store');
Route::put('/pemeliharaan/delete/{id}', [PredictController::class, 'hapus_pemeliharaan'])->name('pemeliharaan.hapus');
Route::put('pemeliharaan/edit/{id}', [PredictController::class, 'edit_pemeliharaan'])->name('pemeliharaan.edit');

Route::get('/list', [UserController::class, 'list'])->name('list');
Route::post('/add_list', [UserController::class, 'add_list'])->name('list.add');
Route::put('/list/edit/{id}', [UserController::class, 'edit_list'])->name('list.edit');
Route::put('/list/delete/{id}', [UserController::class, 'hapus_list'])->name('list.hapus');

Route::get('/selesaiservis', action: function () {
    return view('servis.selesai_servis');
})->name('selesaiservis');





>>>>>>> Stashed changes
