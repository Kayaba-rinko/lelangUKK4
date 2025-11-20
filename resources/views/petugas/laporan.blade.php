@extends('layouts.dashboard')
@section('title', 'Laporan Petugas')
@section('content')
    <div class="main-content">
        <div class="header">
            <h1>Laporan Lelang Petugas</h1>
            <div class="header-right">
            </div>
        </div>
        <div class="card-box">
            <div
                class="header-card-box"style="display: flex;flex-direction: row-reverse;flex-wrap: nowrap;align-content: flex-start;justify-content: space-between;">
                {{-- <h2 style="align-items: end; display: flex; justify-content: end;">Total :
                    {{ number_format($grandtotal) }}</h2> --}}
                    {{-- <a class="btn-primary" href="{{ route('petugas.cetak.laporan.admin') }}">Cetak</a> --}}
                    <form action="{{ route('petugas.cetak.laporan.tanggal') }}" method="GET" class="search-box"
                        style="display: flex; align-items:center; gap:10px; padding:6px 10px;max-width: 45%;">
                        <label for="tgl_lelang" style="font-size:14px;">Dari:</label>
                        <input type="date" name="tgl_lelang"
                            style="font-size: 14px"value="{{ request('tgl_lelang') ?? ($tgl_lelang ?? '') }}" required>
                        <label for="tanggal_akhir" style="font-size:14px;">Sampai:</label>
                        <input type="date" name="tanggal_akhir"
                            style="font-size: 14px"value="{{ request('tanggal_akhir') ?? ($tanggal_akhir ?? '') }}"
                            required>
                        <button type="submit" class="btn-search">Filter</button>
                    </form>
                </div>
            <a class="btn-primary" target="_blank" href="{{ route('petugas.cetak.laporan') }}">Cetak</a>
            <table class="table-dark">
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
                            <td>{{ number_format($item->harga_akhir) }} IDR</td>
                            <td>
                                @if ($item->barang->gambar)
                                    <img src="{{ asset('storage/' . $item->barang->gambar) }}" alt="" width="70">
                                @else
                                    Tidak ada gambar
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
