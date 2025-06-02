<?php

namespace App\Http\Controllers;
use App\Models\Pemakaian;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;



class PemakaianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pemakaian()
    {
        $pageTitle = 'Pemakaian';
        $pemakaian = Pemakaian::with('kendaraan')->get();
        $kendaraan = Kendaraan::get();
        return view('pemakaian.pemakaian', compact('pageTitle', 'pemakaian', 'kendaraan'));
    }

    public function add_pemakaian(Request $request)
    {

        $messages = [
            'required' => 'Data Wajib Diisi',
        ];
        $validator = Validator::make($request->all(), [
            'kode_item' => 'required',
            'nama_supir' => 'required',
            'hari' => 'required',
            'km_harian' => 'required',
            'jam_keluar' => 'required',
            'jam_kembali' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('modal_open', true);
        }


        $pemakaian = new Pemakaian;
        $pemakaian->kendaraan_id = $request->kode_item;
        $pemakaian->nama_supir = $request->nama_supir;
        $pemakaian->hari = $request->hari;
        $pemakaian->km_harian = $request->km_harian;
        $pemakaian->jam_keluar = $request->jam_keluar;
        $pemakaian->jam_kembali = $request->jam_kembali;
        $pemakaian->history_kendaraan = $request->kode_item;
        $pemakaian->save();

        // Konversi ke waktu
        $jam_keluar = Carbon::createFromFormat('H:i', $pemakaian->jam_keluar);
        $jam_kembali = Carbon::createFromFormat('H:i', $pemakaian->jam_kembali);

        // Hitung durasi dalam jam
        $selisih_jam = $jam_keluar->diffInMinutes($jam_kembali) / 60;
        // Simpan ke kolom
        $rata_rata = Pemakaian::where('kendaraan_id', $request->kode_item)->avg('km_harian');

        $kendaraan = Kendaraan::find($pemakaian->kendaraan_id);
        $kendaraan->jam_operasi_perbulan = $kendaraan->jam_operasi_perbulan + $selisih_jam;
        $kendaraan->frekuensi_km_harian = $rata_rata;
        $kendaraan->save();
        $pemakaian->history_jumlah = $selisih_jam;
        $pemakaian->save();


        if ($kendaraan->jam_operasi_perbulan < 150) {

            $kendaraan->bulan_prediksi = 0;
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

        return redirect()->route('pemakaian')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit_pemakaian($id, Request $request)
    {

        $messages = [
            'required' => 'Data Wajib Diisi',
        ];
        $validator = Validator::make($request->all(), [
            'edit_kode_item' => 'required',
            'edit_nama_supir' => 'required',
            'edit_hari' => 'required',
            'edit_km_harian' => 'required',
            'edit_jam_keluar' => 'required',
            'edit_jam_kembali' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('modal_open', true);
        }


        $pemakaian = Pemakaian::find($id);
        $pemakaian->kendaraan_id = $request->edit_kode_item;
        $pemakaian->nama_supir = $request->edit_nama_supir;
        $pemakaian->hari = $request->edit_hari;
        $pemakaian->km_harian = $request->edit_km_harian;
        $pemakaian->jam_keluar = $request->edit_jam_keluar;
        $pemakaian->jam_kembali = $request->edit_jam_kembali;
        $pemakaian->save();
        $formatted_jam_keluar = Carbon::createFromFormat('H:i:s', $pemakaian->jam_keluar)->format('H:00');
        $formatted_jam_kembali = Carbon::createFromFormat('H:i:s', $pemakaian->jam_kembali)->format('H:00');

        // Konversi ke waktu
        $jam_keluar = Carbon::createFromFormat('H:i', $formatted_jam_keluar);
        $jam_kembali = Carbon::createFromFormat('H:i', $formatted_jam_kembali);

        // Hitung durasi dalam jam
        $selisih_jam = $jam_keluar->diffInMinutes($jam_kembali) / 60;
        // Simpan ke kolom
        $rata_rata = Pemakaian::where('kendaraan_id', $request->edit_kode_item)->avg('km_harian');

        if ($pemakaian->kendaraan_id != $pemakaian->history_kendaraan) {

            $kendaraan = Kendaraan::find($pemakaian->kendaraan_id);
            $kendaraan->jam_operasi_perbulan = $kendaraan->jam_operasi_perbulan + $selisih_jam;
            $kendaraan->frekuensi_km_harian = $rata_rata;
            $kendaraan->save();
            $pemakaian->history_jumlah = $selisih_jam;
            $pemakaian->history_kendaraan = $pemakaian->kendaraan_id;
            $pemakaian->save();
            if ($kendaraan->jam_operasi_perbulan < 150) {

                $kendaraan->bulan_prediksi = 0;
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
        } else {
            $kendaraan = Kendaraan::find($pemakaian->kendaraan_id);
            $kendaraan->jam_operasi_perbulan = $kendaraan->jam_operasi_perbulan - $pemakaian->history_jumlah + $selisih_jam;
            $kendaraan->frekuensi_km_harian = $rata_rata;

            $kendaraan->save();
            $pemakaian->history_jumlah = $selisih_jam;
            $pemakaian->save();
            if ($kendaraan->jam_operasi_perbulan < 150) {

                $kendaraan->bulan_prediksi = 0;
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
        }

        return redirect()->route('pemakaian')->with('success', 'Data berhasil ditambahkan!');
    }
    public function hapus_pemakaian($id)
    {


        $pemakaian = Pemakaian::find($id);
        $history = $pemakaian->kendaraan_id;
        $formatted_jam_keluar = Carbon::createFromFormat('H:i:s', $pemakaian->jam_keluar)->format('H:00');
        $formatted_jam_kembali = Carbon::createFromFormat('H:i:s', $pemakaian->jam_kembali)->format('H:00');

        // Konversi ke waktu
        $jam_keluar = Carbon::createFromFormat('H:i', $formatted_jam_keluar);
        $jam_kembali = Carbon::createFromFormat('H:i', $formatted_jam_kembali);


        // Hitung durasi dalam jam
        $selisih_jam = $jam_keluar->diffInMinutes($jam_kembali) / 60;
        // Simpan ke kolom

        $kendaraan = Kendaraan::find($pemakaian->kendaraan_id);
        $kendaraan->jam_operasi_perbulan = $kendaraan->jam_operasi_perbulan - $selisih_jam;
        if ($pemakaian) {
            $pemakaian->delete();
        }
        $rata_rata = Pemakaian::where('kendaraan_id', $history)->avg('km_harian');
        $kendaraan->frekuensi_km_harian = $rata_rata;
        $kendaraan->save();


        if ($kendaraan->jam_operasi_perbulan < 150) {

            $kendaraan->bulan_prediksi = 0;
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

        return redirect()->route('pemakaian')->with('success', 'Data berhasil dihapus!');
    }
}
