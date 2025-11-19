@extends('layouts.dashboard')
@section('title', 'Masyarakat Dashboard')

@section('content')
    <div class="main-content">
        <div class="header">
            <h1>Selamat Datang di Dashboard Auctions</h1>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
            <a href="#"onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn-logout">Logout</a>
        </div>
        <div class="user-banner">
            <div class="user-info-box">
                <img src="{{ asset('build/assets/images/4.jpg') }}" class="user-avatar">
                <div class="user-details">
                    <h2>{{ Auth::guard('masyarakat')->user()->name }}</h2>
                    <p class="user-desc">Lihat semua barang lelang & riwayat bid kamu.</p>
                </div>
            </div>
        </div>
        <h2 class="history-title">Riwayat Penawaran Kamu</h2>
        <div class="cariHistory">
            <form action="{{ route('masyarakat.history.cari') }}" method="GET" class="history-form">
                <div class="search-box">
                    <input type="text" name="cari" placeholder="Cari riwayat penawaran..."
                        value="{{ $cari ?? '' }}">
                    <button type="submit" class="btn-primary">🔍</button>
                </div>
            </form>
            <form action="{{ route('masyarakat.history.filter') }}" method="GET" class="history-form">
                <div class="search-box">
                    <select name="status">
                        <option value="">-- Filter by Status --</option>
                        <option value="menang" {{ isset($status) && $status == 'menang' ? 'selected' : '' }}>Menang
                        </option>
                        <option value="kalah" {{ isset($status) && $status == 'kalah' ? 'selected' : '' }}>Kalah</option>
                    </select>
                    <button type="submit" class="btn-primary">Filter</button>
                </div>
            </form>
        </div>

        <div class="dashboard-grid">
            @foreach ($history as $item)
                @php
                    $highestBid = \App\Models\HistoryLelang::where('id_lelang', $item->id_lelang)
                        ->orderBy('penawaran_harga', 'DESC')
                        ->first();
                    $isWinner = $highestBid && $highestBid->id_masyarakat == Auth::guard('masyarakat')->id();
                @endphp
                <div class="dashboard-card">
                    <div class="dashboard-img">
                        <img src="{{ asset('storage/' . $item->lelang->barang->gambar) }}" alt="gambar">
                        <span class="likes-badge">{{ $isWinner ? '🏆 Menang' : '❌ Kalah' }}</span>
                    </div>
                    <h3 class="card-title">"{{ $item->lelang->barang->nama_barang }}"</h3>
                    <div class="current-bid-section" style="font-size: 14px">
                        <small>Penawaran Anda</small>
                        <p>Rp {{ number_format($item->penawaran_harga) }}</p>
                    </div>
                    <div class="current-bid-section" style="font-size: 14px">
                        <small>Penawaran Tertinggi</small>
                        <p>Rp {{ number_format($highestBid->penawaran_harga) }}</p>
                    </div>
                    <div style="margin-top:18px;">
                        <a href="{{ route('masyarakat.history.detail', $item->id_lelang) }}"
                            class="btn-primary"style="width:100%;display:block;text-align:center;">Lihat Detail</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
