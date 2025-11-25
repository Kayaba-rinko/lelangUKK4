@extends('layouts.dashboard')
@section('title', 'Penawaran Lelang')

@section('content')
    <div class="main-content">
        <div class="header">
            <h1>Today's Picks</h1>
            <div class="header-right">
                <form action="{{ route('masyarakat.penawaran.cari') }}" method="GET">
                    <div class="search-box">
                        <input type="text" style="font-size:16px" name="cari" placeholder="Cari barang..." value="{{ $cari ?? '' }}">
                        <button type="submit" class="btn-primary">🔍</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="lelang-grid">
            @foreach ($lelang as $item)
                <div class="lelang-card">
                    <div class="card-img">
                        <img src="{{ asset('storage/' . $item->barang->gambar) }}" alt="barang">
                        <span class="likes" style="background: linear-gradient(90deg, #6a1b9a, #8e44ad);">{{ $item->status }}</span>
                        <div class="countdown-badge" data-end="{{ $item->tanggal_akhir }}">🔥 <span class="time">-- : -- : -- : --</span></div>
                    </div>
                    <h3 class="card-title">"{{ $item->barang->nama_barang }}"</h3>
                    <div class="card-info">
                        <div>
                            <small>Owned by</small>
                            <p>{{ $item->pemenang ? $item->pemenang->name : '-' }}</p>
                        </div>
                        <div class="price-box">
                            <small>Current Bid</small>
                            <p>Rp.{{ number_format($item->harga_akhir) }}</p>
                        </div>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('masyarakat.bid', $item->id_lelang) }}" class="btn-primary">Place Bid</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        document.querySelectorAll('.countdown-badge').forEach(function(badge) {
            let endDate = new Date(badge.dataset.end).getTime();
            let timeBox = badge.querySelector('.time');
            setInterval(() => {
                let now = new Date().getTime();
                let diff = endDate - now;

                if (diff <= 0) {
                    timeBox.innerHTML = "Berakhir";
                    badge.style.background = "#442222";
                    return;
                }
                let days = Math.floor(diff / (1000 * 60 * 60 * 24));
                let hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((diff % (1000 * 60)) / 1000);

                timeBox.innerHTML = `${days} : ${hours} : ${minutes} : ${seconds}`;
            }, 1000);
        });
    </script>

@endsection
