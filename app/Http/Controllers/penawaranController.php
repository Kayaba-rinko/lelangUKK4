<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\HistoryLelang;
use Illuminate\Support\Facades\Auth;

class penawaranController extends Controller
{
    public function index()
    {
        $lelang = Lelang::with(['barang', 'pemenang'])->where('status', 'dibuka')->get();
        return view('masyarakat.penawaran', compact('lelang'));
    }

    public function bid($id_lelang)
    {
        $lelang = Lelang::with('barang')->findOrFail($id_lelang);
        $history = HistoryLelang::with('masyarakat')->where('id_lelang', $id_lelang)->orderBy('penawaran_harga', 'DESC')->get();

        return view('masyarakat.bid', compact('lelang', 'history'));
    }
    public function placeBid(Request $request, $id_lelang)
    {
        $lelang = Lelang::findOrFail($id_lelang);

        $data = [
            'id_barang' => $request->id_barang,
            'tgl_lelang' => $request->tgl_lelang,
            'harga_awal' => $lelang->harga_awal,
            'id_petugas' => $lelang->id_petugas,
        ];
        // if (auth()->guard('petugas')->check()) {
        //     $data['status'] = $request->status;
        //     $data['harga_akhir'] = $lelang->harga_akhir;
        //     $data['id_masyarakat'] = $lelang->id_masyarakat;
        // }
        if (auth()->guard('masyarakat')->check()) {
            $data['harga_akhir'] = $request->harga_akhir;
            $data['id_masyarakat'] = $request->id_masyarakat;
            $data['status'] = $lelang->status;
        }

        $lelang->update($data);
        if (auth()->guard('masyarakat')->check()) {
            HistoryLelang::create([
                'id_lelang' => $lelang->id_lelang,
                'id_barang' => $lelang->id_barang,
                'id_masyarakat' => $data['id_masyarakat'],
                'penawaran_harga' => $request->harga_akhir,
            ]);
        }

        return redirect()->route('masyarakat.penawaran')->with('success', 'Lelang berhasil dirubah!');
    }

    public function history()
    {
        $masyarakatId = Auth::guard('masyarakat')->id();

        $history = HistoryLelang::with(['lelang.barang'])->where('id_masyarakat', $masyarakatId)->orderBy('created_at', 'DESC')->get();

        return view('masyarakat.dashboard', compact('history'));
    }
}
