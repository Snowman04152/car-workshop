<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list()
    {
        $pageTitle = 'list';
        $list = User::get();
        return view('settings.list', compact('pageTitle', 'list'));
    }

    public function add_list(Request $request)
    {
        $messages = [
            'required' => 'Data Wajib Diisi',
        ];
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('modal_open', true);
            ;
        }
        $user = new User;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->password = Hash::make($request->password);
        // dd($jenis);
        $user->save();
        return redirect()->route('list');
    }

    public function edit_list(Request $request, string $id)
    {
        $messages = [
            'required' => 'Data Wajib Diisi',
        ];
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'role' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('modal_open', true);
            ;
        }
        $user = User::find($id);
        $user->email = $request->email;
        $user->role_id = $request->role;
        if ($request->password != null)
            $user->password = Hash::make($request->password);
        else
            // dd($jenis);
            $user->save();
        return redirect()->route('list');
    }

    public function hapus_list(string $id)
    {
        dd($id);
        $deleteduser = User::find($id);
        if ($deleteduser) {
            $deleteduser->delete();
        }
        return redirect()->route('list');
    }
}
