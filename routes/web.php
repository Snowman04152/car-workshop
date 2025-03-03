<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dashboard');

Route::get('/login', function () {
    return view('login.login');
})->name('login');

Route::get('/jenis', function () {
    return view('master_data.jenis');
})->name('jenis');

Route::get('/kendaraan', function () {
    return view('master_data.kendaraan');
})->name('kendaraan');

Route::get('/merk', function () {
    return view('master_data.merk');
})->name('merk');

Route::get('/servis', action: function () {
    return view('servis.servis');
})->name('servis');

Route::get('/selesaiservis', action: function () {
    return view('servis.selesai_servis');
})->name('selesaiservis');

Route::get('/laporanmasuk', action: function () {
    return view('laporan.laporan_masuk');
})->name('laporanmasuk');

Route::get('/laporanselesai', action: function () {
    return view('laporan.laporan_selesai');
})->name('laporanselesai');

Route::get('/pemeliharaan', action: function () {
    return view('pemeliharaan.pemeliharaan');
})->name('pemeliharaan');

Route::get('/role', action: function () {
    return view('settings.role');
})->name('role');

Route::get('/list', action: function () {
    return view('settings.list');
})->name('list');