<?php

namespace App\Http\Controllers;
use App\Models\Servis;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Validator;


class ServisController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function servis()
    {
        $pageTitle = 'Servis';
        $kendaraan = Kendaraan::with(['jenis', 'merk'])->where('hapus_id', 0)->get();
        $servis = Servis::with(['kendaraan', 'kendaraan.jenis', 'kendaraan.merk'])->where('hapus_id', 0)->get();
        // dd($servis);
        return view('servis.servis', compact('pageTitle', 'kendaraan', 'servis'));
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
        $servis->kendaraan_id = $request->kode_item;
        $servis->tanggal_masuk = $request->tanggal_masuk;
        $servis->status = $request->status;
        $servis->hapus_id = 0;
        // dd($servis);
        $servis->save();
        return redirect()->route('servis');
    }
    public function edit_servis(Request $request, string $id)
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
            
        }
        $servis = Servis::find($id);
        if ($request->tanggal_keluar != null)
            $servis->tanggal_selesai = $request->tanggal_keluar;
        $servis->kendaraan_id = $request->kode_item;
        $servis->tanggal_masuk = $request->tanggal_masuk;
        $servis->status = $request->status;
        $servis->hapus_id = 0;
        // dd($servis);
        $servis->save();
        return redirect()->route('servis');
    }
    public function hapus_servis(string $id){
        $servis = Servis::find($id);
        $servis->hapus_id = 1;
        $servis->save();
        return redirect()->route('servis');
    }


}
