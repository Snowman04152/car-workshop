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
        $pemakaian = Pemakaian::with('kendaraan')
            ->whereHas('kendaraan', function ($query) {
                $query->where('hapus_id', 0);
            })
            ->orderByRaw('CASE WHEN jam_kembali IS NULL THEN 0 ELSE 1 END')
            ->orderBy('created_at', 'desc')
            ->get();


        $kendaraan = Kendaraan::where('hapus_id', 0)->get();
        return view('pemakaian.pemakaian', compact('pageTitle', 'pemakaian', 'kendaraan'));
    }

    public function add_pemakaian(Request $request)
    {

        $messages = [
            'required' => 'Data Wajib Diisi',
            // 'km_harian_kembali.gte' => 'KM kembali harus lebih besar dari KM keluar.',
            // pesan lainnya jika diperlukan
        ];

        $messages = [
            'required' => 'Data Wajib Diisi',
        ];

        $validator = Validator::make($request->all(), [
            'kode_item' => 'required',
            'nama_supir' => 'required',
            'hari' => 'required',
            'km_harian_keluar' => 'required|numeric',
            'km_harian_kembali' => 'nullable|numeric',
            'jam_keluar' => 'required',
        ], $messages);

        // Validasi tambahan
        $validator->after(function ($validator) use ($request) {
            // Validasi KM kembali
            if (!is_null($request->km_harian_kembali) && $request->km_harian_kembali < $request->km_harian_keluar) {
                $validator->errors()->add('km_harian_kembali', 'KM kembali tidak boleh lebih kecil dari KM keluar.');
            }

            // Validasi duplikat kombinasi kode_item + hari
            $exists = \DB::table('pemakaians')
                ->where('kendaraan_id', $request->kode_item)
                ->where('hari', $request->hari)
                ->exists();

            if ($exists) {
                $validator->errors()->add('hari', 'Data dengan Kendaraan hari ini sudah ada.');
                $validator->errors()->add('kode_item', 'Data dengan Kendaraan hari ini sudah ada.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('modal_open', true);
        }

        $pemakaian = new Pemakaian;
        $pemakaian->kendaraan_id = $request->kode_item;
        $pemakaian->nama_supir = $request->nama_supir;
        $pemakaian->hari = $request->hari;
        $pemakaian->km_harian_keluar = $request->km_harian_keluar;
        $pemakaian->km_harian_kembali = $request->km_harian_kembali;
        // $pemakaian->km_harian = $request->km_harian;
        $pemakaian->jam_keluar = $request->jam_keluar;
        $pemakaian->jam_kembali = $request->jam_kembali;
        $pemakaian->history_kendaraan = $request->kode_item;

        $formatted_jam_keluar = Carbon::parse($request->jam_keluar)->format('H:i');
        if ($request->jam_kembali != null || 0) {
            $formatted_jam_kembali = Carbon::parse($request->jam_kembali)->format('H:i');
        } else {
            $formatted_jam_kembali = null;
        }

        // Konversi ke waktu
        $jam_keluar = Carbon::createFromFormat('H:i', $formatted_jam_keluar);
        if ($formatted_jam_kembali != null || 0) {
            $jam_kembali = Carbon::createFromFormat('H:i', $formatted_jam_kembali);
        }else{
            $jam_kembali = null ;
        }

        // Hitung durasi dalam jam

        // Simpan ke kolom

        $kendaraan = Kendaraan::find($pemakaian->kendaraan_id);
        if ($request->km_harian_kembali == null || 0) {
            $rata_rata = Pemakaian::where('kendaraan_id', $request->kode_item)->avg('km_harian');
            $kendaraan->frekuensi_km_harian = $rata_rata;
            $kendaraan->save();
        } else {

            $pemakaian->km_harian = $request->km_harian_kembali - $request->km_harian_keluar;
            $pemakaian->save();
            $rata_rata = Pemakaian::where('kendaraan_id', $request->kode_item)->avg('km_harian');
            $kendaraan->frekuensi_km_harian = $rata_rata;
            $kendaraan->save();
        }

        if ($jam_kembali != null || 0) {
            $selisih_jam = $jam_keluar->diffInMinutes($jam_kembali) / 60;
            $kendaraan->jam_operasi_perbulan = $kendaraan->jam_operasi_perbulan + $selisih_jam;

            $kendaraan->save();
            $pemakaian->history_jumlah = $selisih_jam;
            $pemakaian->save();
        }




        if ($kendaraan->jam_operasi_perbulan < 150) {

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
                'frekuensi_km_harian' => (int) $kendaraan->frekuensi_km_harian,
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
            'edit_jam_keluar' => 'required',
        ], $messages);

        // Validasi tambahan
        $validator->after(function ($validator) use ($request) {
            // Ambil ID dari data yang sedang diedit
            $id = $request->id; // pastikan input hidden 'id' dikirim dari form

            // Cek apakah kombinasi kode_item + hari sudah digunakan oleh entri lain
            $exists = \DB::table('pemakaians')
                ->where('kendaraan_id', $request->edit_kode_item)
                ->where('hari', $request->edit_hari)
                ->where('id', '!=', $id) // Kecuali dirinya sendiri
                ->exists();

            if ($exists) {
                $validator->errors()->add('edit_kode_item', 'Data dengan kode item dan hari ini sudah ada.');
                $validator->errors()->add('edit_hari', 'Data dengan kode item dan hari ini sudah ada.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('open_modal', 'modalB');
        }


        $pemakaian = Pemakaian::find($id);
        $pemakaian->kendaraan_id = $request->edit_kode_item;
        $pemakaian->nama_supir = $request->edit_nama_supir;
        $pemakaian->hari = $request->edit_hari;
        $pemakaian->km_harian_keluar = $request->edit_km_keluar;
        $pemakaian->km_harian_kembali = $request->edit_km_kembali;
        // $pemakaian->km_harian = $request->edit_km_harian;
        $pemakaian->jam_keluar = $request->edit_jam_keluar;
        $pemakaian->jam_kembali = $request->edit_jam_kembali;
        $pemakaian->save();

        $formatted_jam_keluar = Carbon::parse($request->edit_jam_keluar)->format('H:i');
        if ($request->jam_kembali != null || 0) {
            $formatted_jam_kembali = Carbon::parse($request->edit_jam_kembali)->format('H:i');
        } else {
            $formatted_jam_kembali = null;
        }

        // Konversi ke waktu
        $jam_keluar = Carbon::createFromFormat('H:i', $formatted_jam_keluar);
        if ($formatted_jam_kembali != null || 0) {
            $jam_kembali = Carbon::createFromFormat('H:i', $formatted_jam_kembali);
        }else{
            $jam_kembali = null ;
        }
        // Hitung durasi dalam jam
        // Simpan ke kolom



        if ($pemakaian->kendaraan_id != $pemakaian->history_kendaraan) {

            $kendaraan = Kendaraan::find($pemakaian->kendaraan_id);
            if ($request->edit_km_kembali == null || 0) {


                $rata_rata = Pemakaian::where('kendaraan_id', $request->edit_kode_item)->avg('km_harian');
                $kendaraan->frekuensi_km_harian = $rata_rata;
                $kendaraan->save();
            } else {
                $pemakaian->km_harian = $request->edit_km_kembali - $request->edit_km_keluar;
                $pemakaian->save();
                $rata_rata = Pemakaian::where('kendaraan_id', $request->edit_kode_item)->avg('km_harian');
                $kendaraan->frekuensi_km_harian = $rata_rata;
                $kendaraan->save();
            }
            if ($jam_kembali != null || 0) {
                $selisih_jam = $jam_keluar->diffInMinutes($jam_kembali) / 60;
                $kendaraan->jam_operasi_perbulan = $kendaraan->jam_operasi_perbulan + $selisih_jam;
                $kendaraan->save();
                $pemakaian->history_jumlah = $selisih_jam;
                $pemakaian->history_kendaraan = $pemakaian->kendaraan_id;
                $pemakaian->save();
            }
            if ($kendaraan->jam_operasi_perbulan < 150) {

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
                    'frekuensi_km_harian' => (int) $kendaraan->frekuensi_km_harian,
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
            if ($request->edit_km_kembali == null || 0) {
                $rata_rata = Pemakaian::where('kendaraan_id', $request->edit_kode_item)->avg('km_harian');
                // dd(Pemakaian::where('kendaraan_id', $request->edit_kode_item)->get());
                $kendaraan->frekuensi_km_harian = $rata_rata;
                $kendaraan->save();
            } else {
                $pemakaian->km_harian = $request->edit_km_kembali - $request->edit_km_keluar;
                $pemakaian->save();
                $rata_rata = Pemakaian::where('kendaraan_id', $request->edit_kode_item)->avg('km_harian');
                $kendaraan->frekuensi_km_harian = $rata_rata;
                $kendaraan->save();
            }
            if ($jam_kembali != null || 0) {
                $selisih_jam = $jam_keluar->diffInMinutes($jam_kembali) / 60;
                $kendaraan->jam_operasi_perbulan = $kendaraan->jam_operasi_perbulan - $pemakaian->history_jumlah + $selisih_jam;
                $kendaraan->save();
                $pemakaian->history_jumlah = $selisih_jam;
                $pemakaian->save();
            }
            ;
            // dd($kendaraan->jam_operasi_perbulan);
            if ($kendaraan->jam_operasi_perbulan < 150) {


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
                    'frekuensi_km_harian' => (int) $kendaraan->frekuensi_km_harian,
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
                if (!$response->successful()) {
                    \Log::error('API gagal:', ['response' => $response->body()]);
                }
            }
        }

        return redirect()->route('pemakaian')->with('success', 'Data berhasil ditambahkan!');
    }
    public function hapus_pemakaian($id)
    {


        $pemakaian = Pemakaian::find($id);
        $history = $pemakaian->kendaraan_id;
        if ($pemakaian->jam_kembali != null) {
             $formatted_jam_keluar = Carbon::parse($pemakaian->jam_keluar)->format('H:i');
        if ($pemakaian->jam_kembali != null || 0) {
            $formatted_jam_kembali = Carbon::parse($pemakaian->jam_kembali)->format('H:i');
        } else {
            $formatted_jam_kembali = null;
        }

        // Konversi ke waktu
        $jam_keluar = Carbon::createFromFormat('H:i', $formatted_jam_keluar);
        if ($formatted_jam_kembali != null || 0) {
            $jam_kembali = Carbon::createFromFormat('H:i', $formatted_jam_kembali);
        }else{
            $jam_kembali = null ;
        }


            // Hitung durasi dalam jam
            if ($jam_kembali != null || 0) {
                $selisih_jam = $jam_keluar->diffInMinutes($jam_kembali) / 60;
                // Simpan ke kolom
                $kendaraan = Kendaraan::find($pemakaian->kendaraan_id);
                $hasil = $kendaraan->jam_operasi_perbulan - $selisih_jam;
                if($hasil >= 0){
                    $kendaraan->jam_operasi_perbulan = $kendaraan->jam_operasi_perbulan - $selisih_jam;
                    $kendaraan->save();
                }else{
                    $kendaraan->jam_operasi_perbulan = 0 ;
                    $kendaraan->save();
                }

            }
            if ($pemakaian) {
                $pemakaian->delete();
            }
            $rata_rata = Pemakaian::where('kendaraan_id', $history)->avg('km_harian');
            $kendaraan->frekuensi_km_harian = $rata_rata;
            $kendaraan->save();


            if ($kendaraan->jam_operasi_perbulan < 150) {


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
                    'frekuensi_km_harian' => (int) $kendaraan->frekuensi_km_harian,
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
            if ($pemakaian) {
                $pemakaian->delete();
            }
        }
        return redirect()->route('pemakaian')->with('success', 'Data berhasil dihapus!');
    }
}
