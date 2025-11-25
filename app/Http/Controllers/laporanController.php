<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\Petugas;
use App\Models\historyLelang;
use App\Models\Level;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class laporanController extends Controller
{

    public function index()
    {
        $level = Auth::user()->id_level;

        if ($level == 1) {
            return $this->adminDashboard();
        } else {
            return $this->petugasDashboard();
        }
    }

    private function adminDashboard()
    {
        $totalUser      = Masyarakat::count();
        $totalPetugas   = Petugas::count() - 1; 
        $totalBarang    = Barang::count();
        $totalLelang    = Lelang::count();

        $totalPendapatan = Lelang::where('status', 'ditutup')->whereNotNull('id_masyarakat')->sum('harga_akhir');
        $chartData = Lelang::selectRaw('MONTH(tgl_lelang) as bulan, COUNT(*) as total')->groupBy('bulan')->orderBy('bulan')->get();
        $recentBids = HistoryLelang::with(['lelang.barang', 'masyarakat'])->latest()->take(3)->get();

        return view('petugas.dashboardAdmin', compact(
            'totalUser',
            'totalPetugas',
            'totalBarang',
            'totalLelang',
            'totalPendapatan',
            'chartData',
            'recentBids'
        ));
    }

    private function petugasDashboard()
    {
        $id = Auth::guard('petugas')->id();

        $totalBarang = Barang::count();
        $totalLelangPetugas = Lelang::where('id_petugas', $id)->count();
        $totalPendapatan = Lelang::where('id_petugas', $id)->where('status', 'ditutup')->whereNotNull('id_masyarakat')->sum('harga_akhir');

        $chartData = Lelang::select(
            DB::raw('MONTH(tgl_lelang) as bulan'),
            DB::raw('COUNT(*) as total')
        )->groupBy('bulan')->orderBy('bulan')->get();

        $topLelang = Lelang::where('id_petugas', $id)->with('barang')->orderByDesc('harga_akhir')->take(3)->get();

        return view('petugas.dashboard', compact(
            'totalBarang',
            'totalLelangPetugas',
            'totalPendapatan',
            'chartData',
            'topLelang'
        ));
    }
}
