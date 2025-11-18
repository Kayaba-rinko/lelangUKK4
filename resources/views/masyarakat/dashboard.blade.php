@extends('layouts.dashboard')
@section('title', 'Masyarakat Dashboard')

@section('content')
    <div class="main-content">
        <div class="header">
            <h1>Live Auctions</h1>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
            <a href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"class="btn-logout">Logout</a>
        </div>
        <div class="user-banner">
            <div class="user-info-box">
                <img src="{{ asset('build/assets/images/4.jpg') }}" class="user-avatar">
                <div class="user-details">
                    <h2>{{ Auth::guard('masyarakat')->user()->name }}</h2>
                    <p class="user-desc">Selamat datang di halaman dashboard masyarakat. Lihat semua barang lelang & riwayat
                        bid kamu.</p>
                </div>
            </div>
        </div>
        {{-- <div class="dashboard-tabs">
            <button class="tab-btn active">Semua</button>
            <button class="tab-btn">Barang</button>
            <button class="tab-btn">Bid</button>
        </div> --}}
        <div class="dashboard-grid">
            @foreach ($history as $item)
                <div class="dashboard-card">

                    <div class="dashboard-img">
                        <img src="{{ asset('storage/' . $item->barang->gambar) }}" alt="gambar">
                        {{-- <span class="likes-badge">❤ 100</span> --}}
                    </div>

                    <h3 class="card-title">"{{ $item->barang->nama_barang }}"</h3>

                    <div class="card-meta">
                        <div class="creator-box">
                            <img src="{{ asset('build/assets/images/4.jpg') }}" class="creator-photo">
                            {{-- <div>
                                <small>Creator</small>
                                <p>{{ $item->petugas->nama_petugas }}</p>
                            </div> --}}
                        </div>
                    </div>

                    <div class="current-bid-section">
                        <small>Current Bid</small>
                        <p>Rp {{ number_format($item->penawaran_harga) }}</p>
                    </div>

                    {{-- <div class="card-footer">
                        <a href="{{ route('masyarakat.bid', $item->id_lelang) }}" class="btn-primary">
                            Place Bid
                        </a>

                        <a href="#" class="view-history-link">View History</a>
                    </div> --}}
                </div>
            @endforeach
        </div>

        <h2 class="history-title">Riwayat Penawaran Kamu</h2>

        {{-- <div class="history-list">
            @if (isset($history) && count($history) > 0)
                @foreach ($history as $item)
                    <div class="dashboard-card">

                        <div class="dashboard-card-img">
                            <img src="{{ asset('storage/' . $item->lelang->barang->gambar) }}" alt="gambar">
                        </div>

                        <div class="dashboard-card-info">
                            <h3>{{ $item->lelang->barang->nama_barang }}</h3>

                            <p class="history-price">
                                Anda Bid: Rp {{ number_format($item->penawaran_harga) }}
                            </p>

                            <small class="history-time">
                                {{ $item->created_at->diffForHumans() }}
                            </small>
                        </div>

                    </div>
                @endforeach
            @else
                <p class="empty">Anda belum pernah mengikuti lelang.</p>
            @endif
        </div> --}}


    </div>
@endsection
