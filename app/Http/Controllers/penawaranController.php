<?php

namespace App\Http\Controllers;

use App\Models\Barang;
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

        foreach ($lelang as $item) {
            if ($item->tanggal_akhir && $item->tanggal_akhir < now()) {
                $item->status = "ditutup";
                $item->save();
            }
        }
        $lelang = Lelang::with('barang')->where('status', 'dibuka')->get();

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

        $history = HistoryLelang::with(['lelang.barang'])
            ->where('id_masyarakat', $masyarakatId)
            ->select('id_lelang', 'id_barang', 'id_masyarakat', 'penawaran_harga', 'created_at')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->unique('id_lelang');
        foreach ($history as $item) {
            $lelang = $item->lelang;
            $tertinggi = HistoryLelang::where('id_lelang', $item->id_lelang)->orderBy('penawaran_harga', 'DESC')->first();
            if ($lelang->status == 'dibuka') {
                $item->status_view = "PROSES";
            } else {
                if ($tertinggi && $tertinggi->id_masyarakat == $masyarakatId) {
                    $item->status_view = "menang";
                } else {
                    $item->status_view = "kalah";
                }
            }
        }
        return view('masyarakat.dashboard', compact('history'));
    }
    public function historyDetail($id_lelang)
    {
        $userId = Auth::guard('masyarakat')->id();
        $lelang = Lelang::with('barang')->findOrFail($id_lelang);
        $history = HistoryLelang::with('masyarakat')->where('id_lelang', $id_lelang)->orderBy('penawaran_harga', 'DESC')->get();
        $highestBid = $history->first();
        $bidKamu = HistoryLelang::where('id_lelang', $id_lelang)->where('id_masyarakat', $userId)->orderBy('penawaran_harga', 'DESC')->first();
        $proses = ($lelang->status == 'dibuka') ? true : false;
        $isWinner = false;

        if (!$proses) {
            if ($highestBid && $highestBid->id_masyarakat == $userId) {
                $isWinner = true;
            }
        }
        return view('masyarakat.detailHistory', compact('lelang', 'history', 'bidKamu', 'isWinner', 'proses', 'highestBid'));
    }
    public function cari(Request $request)
    {
        $cari = $request->input('cari');
        $lelang = Lelang::with(['barang', 'pemenang'])->where('status', 'dibuka')->whereHas('barang', function ($query) use ($cari) {
            $query->where('nama_barang', 'like', '%' . $cari . '%');
        })->get();
        return view('masyarakat.penawaran', compact('lelang', 'cari'));
    }
    public function historycarimasyarakat(Request $request)
    {
        $cari = trim($request->input('cari', ''));
        $userId = Auth::guard('masyarakat')->id();
        $query = HistoryLelang::with(['lelang.barang'])->where('id_masyarakat', $userId)->orderBy('created_at', 'DESC');
        if ($cari !== '') {
            $query->whereHas('lelang.barang', function ($q) use ($cari) {
                $q->where('nama_barang', 'like', '%' . $cari . '%');
            });
        }
        $history = $query->get()->unique('id_lelang')->values();
        return view('masyarakat.dashboard', compact('history', 'cari'));
    }
    public function historyStatus(Request $request)
    {
        $userId = Auth::guard('masyarakat')->id();
        $status = $request->input('status');

        $history = HistoryLelang::with(['lelang.barang'])->where('id_masyarakat', $userId)->select('id_lelang', 'id_barang', 'id_masyarakat', 'penawaran_harga', 'created_at')->orderBy('created_at', 'DESC')->get()->unique('id_lelang')->values();
        foreach ($history as $item) {

            $lelang = $item->lelang;

            $highestBid = HistoryLelang::where('id_lelang', $item->id_lelang)
                ->orderBy('penawaran_harga', 'DESC')
                ->first();

            if ($lelang->status == 'dibuka') {
                $item->status_view = 'proses';
            } else {
                if ($highestBid && $highestBid->id_masyarakat == $userId) {
                    $item->status_view = 'menang';
                } else {
                    $item->status_view = 'kalah';
                }
            }
        }
        if (!$status) {
            return view('masyarakat.dashboard', compact('history', 'status'));
        }
        $filtered = $history->filter(function ($item) use ($status) {
            return $item->status_view === $status;
        })->values();

        return view('masyarakat.dashboard', [
            'history' => $filtered,
            'status'  => $status,
        ]);
    }
}
