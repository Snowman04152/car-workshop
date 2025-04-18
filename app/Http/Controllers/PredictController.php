<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Pemeliharaan;
class PredictController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_item' => 'required|string',
            'usia_mesin' => 'required|integer',
            'bulan_terakhir_servis' => 'required|integer',
            'jenis_pemeliharaan_1' => 'required|integer',
            'jenis_pemeliharaan_2' => 'nullable|integer',
            'jenis_pemeliharaan_3' => 'nullable|integer',
            'interval_km' => 'required|integer',
            'frekuensi_harian' => 'required|integer',
            'jam_operasi' => 'required|integer',
            'riwayat_masalah' => 'required|integer',
        ]);

        // Simpan data ke model secara manual
       
        $service = new Pemeliharaan;
        $service->servis_id = $request->kode_item;
        $service->usia_mesin = $request->usia_mesin;
        $service->servis_terakhir_bulan = $request->bulan_terakhir_servis;
        $service->jenis_pemeliharaan_1 = $request->jenis_pemeliharaan_1;
        $service->jenis_pemeliharaan_2 = $request->jenis_pemeliharaan_2;
        $service->jenis_pemeliharaan_3 = $request->jenis_pemeliharaan_3;
        $service->interval_km = $request->interval_km;
        $service->frekuensi_km_harian = $request->frekuensi_harian;
        $service->jam_operasi_bulanan = $request->jam_operasi;
        $service->riwayat_masalah = $request->riwayat_masalah;
        $service->hapus_id = 0;
        $service->save(); // Simpan data ke database

        // Kirim ke API Python Flask
        $response = Http::post('http://127.0.0.1:5000/predict', [
            'usia_mesin' => $service->usia_mesin,
            'servis_terakhir_bulan' => $service->servis_terakhir_bulan,
            'jenis_pemeliharaan_1' => $service->jenis_pemeliharaan_1,
            'jenis_pemeliharaan_2' => $service->jenis_pemeliharaan_2 ?? -1,
            'jenis_pemeliharaan_3' => $service->jenis_pemeliharaan_3 ?? -1,
            'interval_km' => $service->interval_km,
            'frekuensi_km_harian' => $service->frekuensi_km_harian,
            'jam_operasi' => $service->jam_operasi_bulanan,
            'riwayat_masalah' => $service->riwayat_masalah,
        ]);

        // Simpan hasil prediksi jika API sukses
        if ($response->successful()) {
            $hasil = $response->json();
            $service->bulan_prediksi = $hasil['bulan'];
            $service->save(); // Update data prediksi
            // \Log::info('Hasil prediksi:', $hasil); // Gantikan dd()
        }

        return redirect()->route('pemeliharaan');
    }
    public function edit_pemeliharaan(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'kode_item' => 'required|string',
            'usia_mesin' => 'required|integer',
            'bulan_terakhir_servis' => 'required|integer',
            'jenis_pemeliharaan_1' => 'required|integer',
            'jenis_pemeliharaan_2' => 'nullable|integer',
            'jenis_pemeliharaan_3' => 'nullable|integer',
            'interval_km' => 'required|integer',
            'frekuensi_harian' => 'required|integer',
            'jam_operasi' => 'required|integer',
            'riwayat_masalah' => 'required|integer',
        ]);
        
        // Simpan data ke model secara manual
        $service =  Pemeliharaan::find($id);
        $service->servis_id = $request->kode_item;
        $service->usia_mesin = $request->usia_mesin;
        $service->servis_terakhir_bulan = $request->bulan_terakhir_servis;
        $service->jenis_pemeliharaan_1 = $request->jenis_pemeliharaan_1;
        $service->jenis_pemeliharaan_2 = $request->jenis_pemeliharaan_2;
        $service->jenis_pemeliharaan_3 = $request->jenis_pemeliharaan_3;
        $service->interval_km = $request->interval_km;
        $service->frekuensi_km_harian = $request->frekuensi_harian;
        $service->jam_operasi_bulanan = $request->jam_operasi;
        $service->riwayat_masalah = $request->riwayat_masalah;
        $service->hapus_id = 0;
        $service->save(); // Simpan data ke database

        // Kirim ke API Python Flask
        $response = Http::post('http://127.0.0.1:5000/predict', [
            'usia_mesin' => $service->usia_mesin,
            'servis_terakhir_bulan' => $service->servis_terakhir_bulan,
            'jenis_pemeliharaan_1' => $service->jenis_pemeliharaan_1,
            'jenis_pemeliharaan_2' => $service->jenis_pemeliharaan_2 ?? -1,
            'jenis_pemeliharaan_3' => $service->jenis_pemeliharaan_3 ?? -1,
            'interval_km' => $service->interval_km,
            'frekuensi_km_harian' => $service->frekuensi_km_harian,
            'jam_operasi' => $service->jam_operasi_bulanan,
            'riwayat_masalah' => $service->riwayat_masalah,
        ]);

        // Simpan hasil prediksi jika API sukses
        if ($response->successful()) {
            $hasil = $response->json();
            $service->bulan_prediksi = $hasil['bulan'];
            $service->save(); // Update data prediksi
            // \Log::info('Hasil prediksi:', $hasil); // Gantikan dd()
        }

        return redirect()->route('pemeliharaan');
    }
    public function hapus_pemeliharaan(string $id){
        $servis = Pemeliharaan::find($id);
        $servis->hapus_id = 1;
        $servis->save();
        return redirect()->route('pemeliharaan');
    }

}

