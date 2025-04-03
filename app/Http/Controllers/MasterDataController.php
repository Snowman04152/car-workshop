<?php

namespace App\Http\Controllers;
use App\Models\Jenis;
use App\Models\Merk;
use App\Models\Pemeliharaan;
use App\Models\Role;    
use App\Models\Servis;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Validator;


class MasterDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function jenis()
    {
        $pageTitle = 'Jenis';
        $jenis = Jenis::get();
        return view('master_data.jenis', compact('pageTitle', 'jenis'));
    }

    public function add_jenis(Request $request)
    {
        $messages = [
            'required' => 'Data Wajib Diisi',
        ];
        $validator = Validator::make($request->all(), [
            'jenis' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('modal_open', true);
            ;
        }
        $jenis = new Jenis;
        $jenis->jenis_item = $request->jenis;
        $jenis->hapus_id = 0;
        // dd($jenis);
        $jenis->save();
        return redirect()->route('jenis');
    }

    public function edit_jenis(Request $request, string $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
        ];
        $validator = Validator::make($request->all(), [
            'edit_jenis' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jenis = Jenis::find($id);

        $jenis->jenis_item = $request->edit_jenis;
        $jenis->save();
        return redirect()->route('jenis');

    }

    public function merk()
    {
        $pageTitle = 'Merk';
        $merk = Merk::get();
        return view('master_data.merk', compact('pageTitle', 'merk'));
    }

    public function add_merk(Request $request)
    {
        $messages = [
            'required' => 'Data Wajib Diisi',
        ];
        $validator = Validator::make($request->all(), [
            'merk' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('modal_open', true);
            ;
        }
        $merk = new Merk;
        $merk->merk_item = $request->merk;
        $merk->hapus_id = 0;
        // dd($jenis);
        $merk->save();
        return redirect()->route('merk');
    }

    public function edit_merk(Request $request, string $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
        ];
        $validator = Validator::make($request->all(), [
            'edit_merk' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $merk = Merk::find($id);

        $merk->merk_item = $request->edit_merk;
        $merk->save();
        return redirect()->route('merk');

    }

    public function kendaraan()
    {
        $pageTitle = 'Kendaraan';
        $kendaraan = Kendaraan::with(['jenis', 'merk'])->where('hapus_id' ,0)->get();
        $merk = Merk::get();
        $jenis = Jenis::get();
        return view('master_data.kendaraan', compact('pageTitle', 'kendaraan', 'merk', 'jenis'));
    }

    public function add_kendaraan(Request $request)
    {
        $messages = [
            'required' => 'Data Wajib Diisi',
        ];
        $validator = Validator::make($request->all(), [
            'nama_kendaraan' => 'required',
            'jenis' => 'required',
            'merk' => 'required',
            'jumlah' => 'required',
            'gambar' => 'required',

        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('modal_open', true);
            ;
        }
        
        $file = $request->file('gambar');
        // $fileSaved = Storage::disk('public')->put($request->file('gambar'));

        // dd($file);
        if ($file != null) {
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();
            // Store File
            $file->store('files','public');
            
        }


        $kendaraan = new Kendaraan;
        $kendaraan->nama_kendaraan = $request->nama_kendaraan;
        $kendaraan->id_jenis = $request->jenis;
        $kendaraan->id_merk = $request->merk;
        $kendaraan->jumlah = $request->jumlah;
        $kendaraan->hapus_id = 0;
        if ($file != null) {
            $kendaraan->original_filename = $originalFilename;
            $kendaraan->encrypted_filename = $encryptedFilename;
            }
            
        $kendaraan->save();
        return redirect()->route('kendaraan');
    }


    public function edit_kendaraan(Request $request, string $id)
    {
        $messages = [
            'required' => 'Data Wajib Diisi',
        ];
        $validator = Validator::make($request->all(), [
            'nama_kendaraan' => 'required',
            'jenis' => 'required',
            'merk' => 'required',
            'jumlah' => 'required',
            

        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('modal_open', true);
            ;
        }
        
        $file = $request->file('gambar');
        // $fileSaved = Storage::disk('public')->put($request->file('gambar'));

        // dd($file);
        if ($file != null) {
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();
            // Store File
            $file->store('files','public');
            
        }


        $kendaraan = Kendaraan::find($id);
        $kendaraan->nama_kendaraan = $request->nama_kendaraan;
        $kendaraan->id_jenis = $request->jenis;
        $kendaraan->id_merk = $request->merk;
        $kendaraan->jumlah = $request->jumlah;
        $kendaraan->hapus_id = 0;
        if ($file != null) {
            $kendaraan->original_filename = $originalFilename;
            $kendaraan->encrypted_filename = $encryptedFilename;
            }
            
        $kendaraan->save();
        return redirect()->route('kendaraan');

    }

    public function hapus_kendaraan(string $id){
        $kendaraan = Kendaraan::find($id);
        $kendaraan->hapus_id = 1;
        $kendaraan->save();
        return redirect()->route('kendaraan');
    }

    

}
