@extends('layouts.dashboard')
@section('title', 'Detail History Lelang')
@section('content')
    <div class="main-content">
        <div class="bid-container">
            <div class="bid-image-box">
                <img src="{{ asset('storage/' . $lelang->barang->gambar) }}" alt="gambar barang">
            </div>
            <div class="bid-info">
                <h2 class="bid-title">{{ $lelang->barang->nama_barang }}</h2>
                <div class="bid-meta">
                    <div class="meta-box"><small>Penawaran Tertinggi</small>
                        <p class="meta-value">
                            @if ($highestBid)
                                Rp {{ number_format($highestBid->penawaran_harga) }}
                            @else
                                Tidak ada penawaran
                            @endif
                        </p>
                    </div>
                    <div class="meta-box"><small>Tanggal Akhir</small><p class="meta-value">{{ \Carbon\Carbon::parse($lelang->tanggal_akhir)->format('d M Y') }}</p></div>
                    <div class="meta-box"><small>Status Anda</small><p class="meta-value" style="font-weight:bold;color: {{ $isWinner ? '#3dbf33' : '#d9534f' }}">{{ $proses ? 'PENDING' : ($isWinner ? 'MENANG' : 'KALAH') }}</p></div>
                    <div class="meta-box"><small>Status Lelang</small><p class="meta-value" style="font-weight:bold;color: {{ $proses ? '#ff0018' : '#5555ff' }}">{{ $proses ? 'PROSES' : 'DITUTUP' }}</p></div>
                </div>
                <div class="your-bid-box" style="margin-top:20px;"><small>Penawaran Anda</small><p class="meta-value" style="font-size:18px;font-weight:bold;">Rp{{ number_format($bidKamu->penawaran_harga) }}</p></div>
                <h3 class="section-title" style="margin-top:30px;">Riwayat Penawaran</h3>
                <div class="bid-history">
                    @forelse($history as $h)
                        <div class="history-row enhanced-history">
                            <div class="history-avatar"><span>{{ strtoupper(substr($h->masyarakat->name, 0, 1)) }}</span></div>
                            <div class="history-info"><p class="history-user"><strong>{{ $h->masyarakat->name }}</strong><spanclass="history-action"> placed a bid</span></p><small class="history-time">{{ $h->created_at->diffForHumans() }}</small></div>
                            <div class="history-price-box"><p class="history-price">Rp {{ number_format($h->penawaran_harga) }}</p></div>
                        </div>
                    @empty
                        <p class="empty-history">Belum ada penawaran.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
