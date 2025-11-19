<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Lelang;
use App\Models\Barang;
use App\Models\historyLelang;
use App\Models\Petugas;
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
            // 'harga_akhir' => 'required|numeric',
            'harga_awal' => 'required|numeric',
        ]);
        $barang = Barang::findOrFail($request->id_barang);
        $lelang = new Lelang;
        $lelang->id_barang = $request->id_barang;
        $lelang->tgl_lelang = $request->tgl_lelang;
        $lelang->tanggal_akhir = $request->tanggal_akhir;
        $lelang->harga_awal = $request->harga_awal;
        $lelang->harga_akhir = $request->harga_awal;
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
        $lelang->status = "dibuka";
        $lelang->save();

        return redirect()->route('petugas.bukaTutup')->with('success', 'Lelang berhasil diperbarui & dibuka kembali');
    }
    public function tutuplelang($id_lelang)
    {
        $petugasId = Auth::guard('petugas')->id();
        $lelang = Lelang::where('id_petugas', $petugasId)->findOrFail($id_lelang);
        $lelang->status = 'ditutup';
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

    public function cari(Request $request)
    {
        $cari = $request->cari;
        $petugasId = Auth::guard('petugas')->id();
        $lelang = Lelang::with('barang')->where('id_petugas', $petugasId)->whereHas('barang', function ($query) use ($cari) {
            $query->where('nama_barang', 'like', "%" . $cari . "%");
        })->get();

        return view('petugas.bukaTutupLelang', compact('lelang', 'cari'));
    }

    // history lelang sesuai dengan lelang yang di kelola petugas
    public function historypetugas()
    {
        $petugasId = Auth::guard('petugas')->id();
        $tgl_lelang = null;
        $tanggal_akhir = null;
        $lelang = Lelang::with(['barang', 'pemenang'])->where('id_petugas', $petugasId)->where('status', 'ditutup')->get();
        return view('petugas.historyPetugas', compact('lelang', 'tgl_lelang', 'tanggal_akhir'));
    }
    public function historypetugascari(Request $request)
    {
        $cari = $request->cari;
        $petugasId = Auth::guard('petugas')->id();
        $lelang = Lelang::with(['barang', 'pemenang'])->where('id_petugas', $petugasId)->where('status', 'ditutup')->whereHas('barang', function ($query) use ($cari) {
            $query->where('nama_barang', 'like', "%" . $cari . "%");
        })->get();
        $tgl_lelang = null;
        $tanggal_akhir = null;

        return view('petugas.historyPetugas', compact('lelang', 'cari', 'tgl_lelang', 'tanggal_akhir'));
    }
    public function tanggal(Request $request)
    {
        $tgl_lelang = $request->input('tgl_lelang');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $petugasId = Auth::guard('petugas')->id();
        $filtered = HistoryLelang::whereHas('lelang', function ($q) use ($petugasId) {
            $q->where('id_petugas', $petugasId);
        })
            ->whereHas('lelang', function ($q) {
                $q->where('status', 'ditutup');
            })
            ->when($tgl_lelang && $tanggal_akhir, function ($query) use ($tgl_lelang, $tanggal_akhir) {
                $query->whereHas('lelang', function ($q) use ($tgl_lelang, $tanggal_akhir) {
                    $q->whereBetween('tgl_lelang', [$tgl_lelang, $tanggal_akhir]);
                });
            })
            ->pluck('id_lelang')
            ->unique();
        $lelang = Lelang::with(['barang', 'pemenang'])
            ->whereIn('id_lelang', $filtered)
            ->get();

        return view('petugas.historyPetugas', compact('lelang', 'tgl_lelang', 'tanggal_akhir'));
    }
    public function laporanindex()
    {
        $petugas = Petugas::all();
        $laporan = collect(); // kosong dulu

        return view('petugas.laporanAdmin', compact('petugas', 'laporan'));
    }

    public function filter(Request $request)
    {
        $petugasId = $request->input('petugas_id');
        $petugas = Petugas::all();

        $laporan = Lelang::with(['barang', 'pemenang'])
            ->where('id_petugas', $petugasId)
            ->where('status', 'ditutup')
            ->get();

        return view('petugas.laporanAdmin', compact('laporan', 'petugas', 'petugasId'));
    }
}
