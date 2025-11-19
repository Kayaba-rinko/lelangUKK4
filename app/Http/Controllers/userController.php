<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masyarakat;

class userController extends Controller
{
    public function index()
    {
        $masyarakat = Masyarakat::all();
        return view('petugas.dataUser', compact('masyarakat'));
    }
    public function create()
    {
        return view('petugas.userform');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:masyarakat,username',
            'password' => 'required|string|min:6',
            'alamat' => 'nullable|string',
            'telp' => 'nullable|string|max:15|unique:masyarakat,telp',
        ]);
        $masyarakat = new Masyarakat;
        $masyarakat->name = $request->name;
        $masyarakat->username = $request->username;
        $masyarakat->password = bcrypt($request->password);
        $masyarakat->alamat = $request->alamat;
        $masyarakat->telp = $request->telp;
        $masyarakat->save();
        return redirect()->route('petugas.userdata')->with('success', 'User berhasil ditambahkan');
    }
    public function edit($id_masyarakat)
    {
        $masyarakat = Masyarakat::findOrFail($id_masyarakat);
        return view('petugas.userform', compact('masyarakat'));
    }
    public function update(Request $request, $id_masyarakat)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:masyarakat,username,' . $id_masyarakat . ',id_masyarakat',
            'password' => 'nullable|string|min:6',
            'alamat' => 'nullable|string',
            'telp' => 'nullable|string|max:15|unique:masyarakat,telp,' . $id_masyarakat . ',id_masyarakat',
        ]);

        $masyarakat = Masyarakat::findOrFail($id_masyarakat);
        $masyarakat->name = $request->name;
        $masyarakat->username = $request->username;
        if ($request->filled('password')) {
            $masyarakat->password = bcrypt($request->password);
        }
        $masyarakat->alamat = $request->alamat;
        $masyarakat->telp = $request->telp;
        $masyarakat->save();

        return redirect()->route('petugas.userdata')->with('success', 'User berhasil diupdate');
    }
    public function destroy($id_masyarakat)
    {
        $masyarakat = Masyarakat::findOrFail($id_masyarakat);
        $masyarakat->delete();

        return redirect()->route('petugas.userdata')->with('success', 'User berhasil dihapus');
    }

    public function blokir($id_masyarakat)
    {
        $user = Masyarakat::findOrFail($id_masyarakat);
        $user->status = 'blokir';
        $user->save();

        return redirect()->route('petugas.userdata')->with('success', 'User berhasil diblokir');
    }

    public function aktifkan($id_masyarakat)
    {
        $user = Masyarakat::findOrFail($id_masyarakat);
        $user->status = 'aktif';
        $user->save();

        return redirect()->route('petugas.userdata')->with('success', 'User berhasil diaktifkan kembali');
    }
    public function cari(Request $request)
    {
        $cari = $request->cari;
        $masyarakat = Masyarakat::where('name', 'like', "%" . $cari . "%")->get();
        return view('petugas.dataUser', data: compact('masyarakat','cari'));
    }
}
