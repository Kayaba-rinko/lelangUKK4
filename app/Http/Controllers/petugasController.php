<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;

class petugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::orderBy('id_petugas')->paginate(5);
        return view('petugas.dataPetugas', compact('petugas'));
    }
    public function create()
    {
        return view('petugas.petugasform');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_petugas' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:petugas,username',
            'password' => 'required|string|min:6',
            // 'id_level' => 'required|exists:levels,id_level',
        ]);
        $petugas = new Petugas;
        $petugas->nama_petugas = $request->nama_petugas;
        $petugas->username = $request->username;
        $petugas->password = bcrypt($request->password);
        $petugas->id_level = 2;
        $petugas->save();
        return redirect()->route('petugas.datapetugas')->with('success', 'Petugas berhasil ditambahkan');
    }
    public function edit($id_petugas)
    {
        $petugas = Petugas::findOrFail($id_petugas);
        return view('petugas.petugasform', compact('petugas'));
    }
    public function update(Request $request, $id_petugas)
    {
        $request->validate(['nama_petugas' => 'required|string|max:255','username' => 'required|string|max:255|unique:petugas,username,' . $id_petugas . ',id_petugas','password' => 'nullable|string|min:6',
            'id_level' => 'required|exists:levels,id_level',
        ]);
        $petugas = Petugas::findOrFail($id_petugas);
        $petugas->nama_petugas = $request->nama_petugas;
        $petugas->username = $request->username;
        if ($request->filled('password')) {
            $petugas->password = bcrypt($request->password);
        }
        $petugas->id_level = $request->id_level;
        $petugas->save();
        return redirect()->route('petugas.datapetugas')->with('success', 'Petugas berhasil diperbarui');
    }
    public function destroy($id_petugas)
    {
        $petugas = Petugas::findOrFail($id_petugas);
        $petugas->delete();
        return redirect()->route('petugas.datapetugas')->with('success', 'Petugas berhasil dihapus');
    }
    public function cari(Request $request)
    {
        $cari = $request->cari;
        $petugas = Petugas::where('nama_petugas', 'like', "%" . $cari . "%")->orderBy('id_petugas')->paginate(5);
        return view('petugas.dataPetugas', compact('petugas', 'cari'));
    }
}
