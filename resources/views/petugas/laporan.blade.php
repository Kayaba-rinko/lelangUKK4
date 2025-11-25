@extends('layouts.dashboard')
@section('title', 'Laporan Petugas')
@section('content')
    <div class="main-content">
        <div class="header">
            <h1>Laporan Lelang Petugas</h1>
            <div class="header-right"></div>
            <div class="header-card-box" style="display:flex; justify-content:space-between; align-items:center; gap:15px;">
                <form action="{{ route('petugas.cetak.laporan.tanggal') }}" method="GET" class="search-box"style="display:flex; align-items:center; gap:10px;">
                    <label for="tgl_lelang" style="font-size:16px;">Dari : </label>
                    <input type="date" name="tgl_lelang" style="font-size:16px; padding:4px;"value="{{ request('tgl_lelang') ?? ($tgl_lelang ?? '') }}" required>
                    <label for="tanggal_akhir" style="font-size:16px;">Sampai : </label>
                    <input type="date" name="tanggal_akhir" style="font-size:16px; padding:4px;"value="{{ request('tanggal_akhir') ?? ($tanggal_akhir ?? '') }}" required>
                    <button type="submit" class="btn-search" style="padding:6px 10px;">Filter</button>
                </form>
                <a class="btn-primary" href="{{ route('petugas.cetak.laporan') }}" style="font-size: 16px; padding:12px;">Cetak</a>
            </div>
        </div>
        <div class="card-box">
            <table class="table-dark" id="dataTable">
                <thead>
                    <tr>
                        <th>ID Lelang</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Lelang</th>
                        <th>Tanggal Akhir</th>
                        <th>Harga Akhir</th>
                        <th>Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lelang as $item)
                        <tr>
                            <td>{{ $item->id_lelang }}</td>
                            <td>{{ $item->barang->nama_barang }}</td>
                            <td>{{ $item->tgl_lelang }}</td>
                            <td>{{ $item->tanggal_akhir }}</td>
                            <td>Rp.{{ number_format($item->harga_akhir) }}</td>
                            <td>
                                @if ($item->barang->gambar)
                                    <img src="{{ asset('storage/' . $item->barang->gambar) }}" alt=""width="70">
                                @else
                                    Tidak ada gambar
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align: center; margin-top: 20px;">
                {{ $lelang->links('vendor.pagination.default') }} 
            </div>
        </div>
    </div>
@endsection
