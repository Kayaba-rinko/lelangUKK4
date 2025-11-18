@extends('layouts.dashboard')
@section('title', 'Place Bid')

@section('content')
    <div class="main-content">
        <div class="header">
            <h1>Penawaran Lelang</h1>
        </div>
        <div class="bid-container">
            <div class="bid-image-box">
                <img src="{{ asset('storage/' . $lelang->barang->gambar) }}" alt="gambar barang">
            </div>
            <div class="bid-info">
                <h2 class="bid-title">{{ $lelang->barang->nama_barang }}</h2>
                <div class="bid-meta">
                    <div class="meta-box">
                        <small>Harga saat ini</small>
                        <p class="meta-value">Rp {{ number_format($lelang->harga_akhir) }}</p>
                    </div>
                    <div class="meta-box">
                        <small>Tanggal Akhir</small>
                        <p class="meta-value">
                            {{ \Carbon\Carbon::parse($lelang->tanggal_akhir)->format('d M Y') }}
                        </p>
                    </div>
                </div>
                {{-- <form action="{{ route('masyarakat.placeBid', $lelang->id_lelang) }}" method="POST"> --}}
                <form action="{{ route('masyarakat.placebid', $lelang->id_lelang) }}" method="POST">
                    @csrf
                    <div class="input-bid-wrapper">
                        {{-- <input type="hidden" name="id_lelang" value="{{ $lelang->id_lelang }}"> --}}
                        <input type="hidden" name="id_barang" value="{{ $lelang->id_barang }}">
                        <input type="hidden" name="id_masyarakat" value="{{ Auth::guard('masyarakat')->id() }}">
                        <input type="hidden" name="tgl_lelang" value="{{ $lelang->tgl_lelang }}">
                        @if ($lelang->harga_akhir != $lelang->harga_awal)
                        <input type="number" min="{{ $lelang->harga_akhir + 1 }}" name="harga_akhir" placeholder="Masukkan jumlah penawaran..." class="input-bid"required>
                        @else
                        <input type="number" min="{{ $lelang->harga_awal + 1 }}" name="harga_akhir" placeholder="Masukkan jumlah penawaran..." class="input-bid"required>
                        @endif
                        <button class="btn-primary btn-bid">Kirim Penawaran</button>
                    </div>
                </form>
                <h3 class="section-title">Riwayat Penawaran</h3>
                <div class="bid-history">
                    @forelse($history as $h)
                        <div class="history-row enhanced-history">
                            <div class="history-avatar">
                                <span>{{ strtoupper(substr($h->masyarakat->name, 0, 1)) }}</span>
                            </div>
                            <div class="history-info">
                                <p class="history-user">
                                    <strong>{{ $h->masyarakat->name }}</strong>
                                    <span class="history-action">placed a bid</span>
                                </p>
                                <small class="history-time">{{ $h->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="history-price-box">
                                <p class="history-price">Rp {{ number_format($h->penawaran_harga) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="empty-history">Belum ada penawaran.</p>
                    @endforelse
                </div>

            </div>
        </div>

    </div>
@endsection
