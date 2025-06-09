<?php

namespace App\Http\Controllers;
use App\Models\Jenis;
use App\Models\Merk;
use App\Models\Pemeliharaan;
use App\Models\Role;
use App\Models\Servis;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;


class MasterDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function kendaraan()
    {
        $pageTitle = 'Kendaraan';
        $kendaraan = Kendaraan::where('hapus_id', 0)->get();
        return view('master_data.kendaraan', compact('pageTitle', 'kendaraan'));
    }

    public function add_kendaraan(Request $request)
    {

        $messages = [
            'required' => 'Data Wajib Diisi',
        ];
        $validator = Validator::make($request->all(), [
            'plat_nomor' => 'required',
            'nama_kendaraan' => 'required',
            'jenis' => 'required',
            'merk' => 'required',
            'riwayat_masalah' => 'required',
            'interval_km' => 'required',
            'bulan_terakhir_servis' => 'required',
            'jenis_pemeliharaan_1' => 'required',
            'tanggal_masuk' => 'required',

        ], $messages);
        $validator->after(function ($validator) use ($request) {
            $exists = \DB::table('kendaraans')
                ->where('plat_nomor', $request->plat_nomor)
                ->where('hapus_id', 0)
                ->exists();

            if ($exists) {
                $validator->errors()->add('plat_nomor', 'Data dengan Kendaraan sudah ada.');
            }
        });
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('modal_open', true);
        }

        $file = $request->file('gambar');
        // $fileSaved = Storage::disk('public')->put($request->file('gambar'));

        // dd($file);
        if ($file != null) {
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();
            // Store File
            $file->store('files', 'public');

        }

        $kendaraan = new Kendaraan;
        $kendaraan->nama_kendaraan = $request->nama_kendaraan;
        $kendaraan->jenis = $request->jenis;
        $kendaraan->plat_nomor = $request->plat_nomor;
        $kendaraan->tanggal_masuk = $request->tanggal_masuk;
        $kendaraan->merk = $request->merk;
        $kendaraan->usia_mesin = Carbon::now()->format('Y') - $request->tanggal_masuk;
        $kendaraan->bulan_terakhir_servis = $request->bulan_terakhir_servis;
        $kendaraan->tahun_terakhir_servis = $request->tahun_terakhir_servis;
        $kendaraan->jenis_pemeliharaan_1 = $request->jenis_pemeliharaan_1;
        $kendaraan->jenis_pemeliharaan_2 = $request->jenis_pemeliharaan_2;
        $kendaraan->jenis_pemeliharaan_3 = $request->jenis_pemeliharaan_3;
        $kendaraan->interval_km = $request->interval_km;
        $kendaraan->frekuensi_km_harian = $request->frekuensi_km_harian;
        $kendaraan->jam_operasi_perbulan = $request->jam_operasi;
        $kendaraan->riwayat_masalah = $request->riwayat_masalah;
        $kendaraan->hapus_id = 0;


        if ($file != null) {
            $kendaraan->original_filename = $originalFilename;
            $kendaraan->encrypted_filename = $encryptedFilename;
        }
        $kendaraan->save();
        if (
            $kendaraan->jam_operasi_perbulan < 150 ||
            is_null($kendaraan->jam_operasi_perbulan) ||
            is_null($kendaraan->frekuensi_km_harian)
        ) {
            $kendaraan->bulan_prediksi = 0;
            $kendaraan->save();
        } else {

            $response = Http::post('http://127.0.0.1:5000/predict', [
                'usia_mesin' => $kendaraan->usia_mesin,
                'servis_terakhir_bulan' => $kendaraan->bulan_terakhir_servis,
                'jenis_pemeliharaan_1' => $kendaraan->jenis_pemeliharaan_1,
                'jenis_pemeliharaan_2' => $kendaraan->jenis_pemeliharaan_2 ?? -1,
                'jenis_pemeliharaan_3' => $kendaraan->jenis_pemeliharaan_3 ?? -1,
                'interval_km' => $kendaraan->interval_km,
                'frekuensi_km_harian' => $kendaraan->frekuensi_km_harian,
                'jam_operasi' => $kendaraan->jam_operasi_perbulan,
                'riwayat_masalah' => $kendaraan->riwayat_masalah,
            ]);
            // Simpan hasil prediksi jika API sukses
            if ($response->successful()) {
                $hasil = $response->json();
                $kendaraan->bulan_prediksi = $hasil['bulan'];
                $kendaraan->save(); // Update data prediksi
                // \Log::info('Hasil prediksi:', $hasil); // Gantikan dd()
            }
        }

        return redirect()->route('kendaraan')->with('success', 'Data berhasil ditambahkan!');
    }


    public function edit_kendaraan(Request $request, string $id)
    {
        $messages = [
            'required' => 'Data Wajib Diisi',
        ];
        $validator = Validator::make($request->all(), [
            'edit_nama_kendaraan' => 'required',
            'edit_jenis' => 'required',
            'edit_merk' => 'required',
            'edit_plat_nomor' => 'required',



        ], $messages);
        $validator->after(function ($validator) use ($request) {
            $id = $request->edit_id_kendaraan;
            $newPlat = $request->edit_plat_nomor;
            $oldPlat = $request->old_plat_nomor;

            // Jika plat nomor berubah, cek apakah plat nomor baru sudah digunakan oleh kendaraan lain
            if ($newPlat !== $oldPlat) {
                $exists = \DB::table('kendaraans')
                    ->where('plat_nomor', $newPlat)
                    ->where('id', '!=', $id) // Kecuali dirinya sendiri
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('edit_plat_nomor', 'Plat nomor tersebut sudah digunakan oleh kendaraan lain.');
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('open_modal', 'modalB');

            ;
        }

        $file = $request->file('gambar');
        // $fileSaved = Storage::disk('public')->put($request->file('gambar'));

        // dd($file);
        if ($file != null) {
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();
            // Store File
            $file->store('files', 'public');

        }


        $kendaraan = Kendaraan::find($id);
        $kendaraan->nama_kendaraan = $request->edit_nama_kendaraan;
        $kendaraan->jenis = $request->edit_jenis;
        $kendaraan->plat_nomor = $request->edit_plat_nomor;
        $kendaraan->merk = $request->edit_merk;
        if ($file != null) {
            $kendaraan->original_filename = $originalFilename;
            $kendaraan->encrypted_filename = $encryptedFilename;
        }
        $kendaraan->save();
        if (
            $kendaraan->jam_operasi_perbulan < 150 ||
            is_null($kendaraan->jam_operasi_perbulan) ||
            is_null($kendaraan->frekuensi_km_harian)
        ) {
            $kendaraan->bulan_prediksi = 0;
            $kendaraan->save();
        } else {
            $response = Http::post('http://127.0.0.1:5000/predict', [
                'usia_mesin' => $kendaraan->usia_mesin,
                'servis_terakhir_bulan' => $kendaraan->bulan_terakhir_servis,
                'jenis_pemeliharaan_1' => $kendaraan->jenis_pemeliharaan_1,
                'jenis_pemeliharaan_2' => $kendaraan->jenis_pemeliharaan_2 ?? -1,
                'jenis_pemeliharaan_3' => $kendaraan->jenis_pemeliharaan_3 ?? -1,
                'interval_km' => $kendaraan->interval_km,
                'frekuensi_km_harian' => $kendaraan->frekuensi_km_harian,
                'jam_operasi' => $kendaraan->jam_operasi_perbulan,
                'riwayat_masalah' => $kendaraan->riwayat_masalah,
            ]);
            // Simpan hasil prediksi jika API sukses
            if ($response->successful()) {
                $hasil = $response->json();
                $kendaraan->bulan_prediksi = $hasil['bulan'];
                $kendaraan->save(); // Update data prediksi
                // \Log::info('Hasil prediksi:', $hasil); // Gantikan dd()
            }
        }
        // Kirim ke API Python Flask
        return redirect()->route('kendaraan')->with('edit', 'Data berhasil diedit!');

    }

    public function hapus_kendaraan(string $id)
    {
        $kendaraan = Kendaraan::find($id);
        $kendaraan->hapus_id = 1;
        $kendaraan->save();
        return redirect()->route('kendaraan')->with('delete', 'Data berhasil dihapus!');
    }
}
