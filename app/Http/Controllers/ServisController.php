<?php

namespace App\Http\Controllers;
use App\Models\Servis;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ServisController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function servis()
    {
        $pageTitle = 'Servis';
        $kendaraan = Kendaraan::where('hapus_id', 0)->get();
        // dd($servis);
        return view('servis.servis', compact('pageTitle', 'kendaraan'));
    }

    public function add_servis(Request $request)
    {
        $messages = [
            'required' => 'Data Wajib Diisi',
        ];
        $validator = Validator::make($request->all(), [
            'kode_item' => 'required',
            'tanggal_masuk' => 'required',
            'status' => 'required',

        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('modal_open', true);
            ;
        }
        $servis = new Servis;
        if ($request->tanggal_keluar != null)
            $servis->tanggal_selesai = $request->tanggal_keluar;
        $servis->kendaraan_id = $request->kode_item;
        $servis->tanggal_masuk = $request->tanggal_masuk;
        $servis->status = $request->status;
        $servis->hapus_id = 0;
        // dd($servis);
        $servis->save();
        return redirect()->route('servis')->with('success', 'Data berhasil ditambahkan!');
    }
    public function edit_servis(Request $request, string $id)
    {
        $messages = [
            'required' => 'Data Wajib Diisi',
        ];
        $validator = Validator::make($request->all(), [
           'riwayat_masalah' => 'required',
            'interval_km' => 'required',
            'frekuensi_km_harian' => 'required',
            'bulan_terakhir_servis' => 'required',
            'jenis_pemeliharaan_1' => 'required',
            'tanggal_masuk' => 'required',
            'jam_operasi' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('modal_open', true);

        }
        $kendaraan = Kendaraan::find($id);
        $kendaraan->tanggal_masuk = $request->tanggal_masuk;
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
        // dd($kendaraan);
        $kendaraan->save();

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

        return redirect()->route('servis')->with('edit', 'Data berhasil diedit!');
    }
    public function hapus_servis(string $id)
    {
        $servis = Kendaraan::find($id);
        $servis->hapus_id = 1;
        $servis->save();
        return redirect()->route('servis')->with('delete', 'Data berhasil dihapus!');
    }


}
