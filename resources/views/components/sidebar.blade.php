@php
    use Illuminate\Support\Facades\Auth;
    $petugas = null;
    $level = null;
    if(Auth::guard('petugas')->check()){
        $petugas = Auth::guard('petugas')->user();
        $level = $petugas->id_level;
    }
@endphp

<div class="sidebar">
    <div class="logo">
        <span>
            @if($level === 1) Admin
            @elseif($level === 2) Petugas
            @else Dashboard
            @endif
        </span>
    </div>

    <nav>
        <ul>
            @if($level === 1)
                <li><a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('petugas.userdata') }}" class="{{ request()->routeIs('petugas.userdata') ? 'active' : '' }}">Data User</a></li>
                <li><a href="{{ route('petugas.datapetugas') }}" class="{{ request()->routeIs('petugas.datapetugas') ? 'active' : '' }}">Data Petugas</a></li>
                <li><a href="{{ route('petugas.barangdata') }}" class="{{ request()->routeIs('petugas.barangdata') ? 'active' : '' }}">Data Barang</a></li>
                <li><a href="{{ route('laporan.admin') }}" class="{{ request()->routeIs('laporan.admin') ? 'active' : '' }}">Laporan</a></li>
            @elseif($level === 2)
                <li><a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('petugas.barangdata') }}" class="{{ request()->routeIs('petugas.barangdata') ? 'active' : '' }}">Pendataan Barang</a></li>
                <li><a href="{{ route('petugas.bukaTutup') }}" class="{{ request()->routeIs('petugas.bukaTutup') ? 'active' : '' }}">Buka & Tutup Lelang</a></li>
                <li><a href="{{ route('laporan.petugas') }}" class="{{ request()->routeIs('laporan.petugas') ? 'active' : '' }}">Laporan</a></li>
                <li><a href="{{ route('history.petugas') }}" class="{{ request()->routeIs('history.petugas') ? 'active' : '' }}">History Petugas</a></li>
            @else
                <li><a href="{{ route('masyarakat.dashboard') }}" class="{{ request()->routeIs('masyarakat.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('masyarakat.penawaran') }}" class="{{ request()->routeIs('masyarakat.penawaran') ? 'active' : '' }}">Lelang</a></li>
            @endif
        </ul>
    </nav>
</div>
