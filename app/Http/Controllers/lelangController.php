<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Lelang;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class lelangController extends Controller
{
    public function index()
    {
        $petugasId = Auth::guard('petugas')->id();
        $lelang = Lelang::with('barang')->where('id_petugas', $petugasId)->get();
        foreach ($lelang as $item) {
            if ($item->tanggal_akhir && $item->tanggal_akhir < today()) {
                $item->status = 'ditutup';
                $item->save();
            }
        }

        return view('petugas.bukaTutupLelang', compact('lelang'));
    }
    public function create()
    {
        $barang = Barang::all();
        return view('petugas.lelangform', compact('barang'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang',
            'tanggal_akhir' => 'required|date|after_or_equal:today',
            'tgl_lelang' => 'required|date',
        ]);
        $barang = Barang::findOrFail($request->id_barang);
        $lelang = new Lelang;
        $lelang->id_barang = $request->id_barang;
        $lelang->tgl_lelang = $request->tgl_lelang;
        $lelang->tanggal_akhir = $request->tanggal_akhir;
        $lelang->harga_awal = $barang->harga_awal;
        $lelang->harga_akhir = $barang->harga_awal;
        $lelang->id_petugas = Auth::guard('petugas')->id();
        $lelang->id_masyarakat = null;
        $lelang->status = "dibuka";
        $lelang->save();

        return redirect()->route('petugas.bukaTutup')->with('success', 'Lelang berhasil ditambahkan');
    }
    public function edit($id_lelang)
    {
        $petugasId = Auth::guard('petugas')->id();
        $data = Lelang::where('id_petugas', $petugasId)->findOrFail($id_lelang);
        $barang = Barang::all();
        return view('petugas.lelangform', compact('data', 'barang'));
    }
    public function update(Request $request, $id_lelang)
    {
        $request->validate([
            'id_barang'      => 'required|exists:barangs,id_barang',
            'tanggal_akhir'  => 'required|date',
            'harga_awal'     => 'required|numeric',
        ]);
        $petugasId = Auth::guard('petugas')->id();
        $lelang = Lelang::where('id_petugas', $petugasId)->findOrFail($id_lelang);
        $lelang->id_barang = $request->id_barang;
        $lelang->tanggal_akhir = $request->tanggal_akhir;
        $lelang->harga_awal = $request->harga_awal;
        $lelang->harga_akhir = $request->harga_awal;
        $lelang->status= "dibuka";
        $lelang->save();

        return redirect()->route('petugas.bukaTutup')->with('success', 'Lelang berhasil diperbarui & dibuka kembali');
    }
    public function tutuplelang($id_lelang)
    {
        $petugasId = Auth::guard('petugas')->id();
        $lelang = Lelang::where('id_petugas', $petugasId)->findOrFail($id_lelang);
        $lelang->status= 'ditutup';
        $lelang->tanggal_akhir = today();
        $lelang->save();

        return redirect()->route('petugas.bukaTutup')->with('success', 'Lelang berhasil ditutup');
    }

    public function destroy($id_lelang)
    {
        $petugasId = Auth::guard('petugas')->id();
        $lelang = Lelang::where('id_petugas', $petugasId)->findOrFail($id_lelang);
        $lelang->delete();
        return redirect()->route('petugas.bukaTutup')->with('success', 'Lelang berhasil dihapus');
    }

}
