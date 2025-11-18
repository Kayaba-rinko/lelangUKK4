<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Carbon\Carbon;

use function Symfony\Component\Clock\now;

class barangController extends Controller
{
    public function index(){
        $barang = Barang::all();
        return view('petugas.barangdata', compact('barang'));
    }
    public function create(){
        return view('petugas.barangform');
    }
    public function store(Request $request){
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            // 'tgl_masuk' => 'date',
            'harga_awal' => 'required|numeric',
            'deskripsi_barang' => 'nullable|string',
            'gambar' => 'nullable|image|max:10800',
        ]);

        $barang = new Barang;
        $barang->nama_barang = $request->nama_barang;
        $barang->tgl_masuk = Carbon::now()->toDateString();
        $barang->harga_awal = $request->harga_awal;
        $barang->deskripsi_barang = $request->deskripsi_barang;
        if($request->hasFile('gambar')){
            $barang->gambar = $request->file('gambar')->store('images', 'public');
        }
        $barang->save();
        return redirect()->route('petugas.barangdata')->with('success', 'Barang berhasil ditambahkan');
    }
    public function edit($id_barang){
        $barang = Barang::findOrFail($id_barang);
        return view('petugas.barangform', compact('barang'));
    }
    public function update(Request $request, $id_barang){
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            // 'tgl_masuk' => 'date',
            'harga_awal' => 'required|numeric',
            'deskripsi_barang' => 'nullable|string',
            'gambar' => 'nullable|image|max:10800',
        ]);

        $barang = Barang::findOrFail($id_barang);
        $barang->nama_barang = $request->nama_barang;
        $barang->tgl_masuk = Carbon::parse($request->tgl_masuk);
        $barang->harga_awal = $request->harga_awal;
        $barang->deskripsi_barang = $request->deskripsi_barang;
        if($request->hasFile('gambar')){
            $barang->gambar = $request->file('gambar')->store('images', 'public');
        }
        $barang->save();
        return redirect()->route('petugas.barangdata')->with('success', 'Barang berhasil diperbarui');
    }
    public function destroy($id_barang){
        $barang = Barang::findOrFail($id_barang);
        $barang->delete();
        return redirect()->route('petugas.barangdata')->with('success', 'Barang berhasil dihapus');
    }
}
