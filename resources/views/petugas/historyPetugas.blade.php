@extends('layouts.dashboard')
@section('title', 'History Lelang')
@section('content')
    <div class="main-content">
        <div class="header">
            <h1>History Lelang Petugas</h1>
            <div class="header-actions" style="display: flex; align-items:center; gap: 15px;">
                <form action="{{ route('petugas.historyPetugas.cari') }}"
                    class="search-box"style="display: flex;align-items:center;">
                    <input style="font-size: 14px" type="text" name="cari" placeholder="Cari History..."
                        value="{{ request('cari') }}">
                    <button type="submit" class="btn-search">🔍</button>
                </form>
                <form action="{{ route('petugas.historyPetugas.filter') }}" method="GET" class="search-box"
                    style="display: flex; align-items:center; gap:10px; padding:6px 10px;">
                    <label for="tgl_lelang" style="font-size:14px;">Dari:</label>
                    <input type="date" name="tgl_lelang"
                        style="font-size: 14px"value="{{ request('tgl_lelang') ?? ($tgl_lelang ?? '') }}" required>
                    <label for="tanggal_akhir" style="font-size:14px;">Sampai:</label>
                    <input type="date" name="tanggal_akhir"
                        style="font-size: 14px"value="{{ request('tanggal_akhir') ?? ($tanggal_akhir ?? '') }}" required>
                    <button type="submit" class="btn-search">Filter</button>
                </form>

            </div>
        </div>

        <div class="card-box">
            <table class="table-dark">
                <thead>
                    <tr>
                        <th>ID Lelang</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Lelang</th>
                        <th>Tanggal Akhir</th>
                        <th>Harga Akhir</th>
                        <th>Gambar</th>
                        <th>Pemenang</th>
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
                            <td>{{ $item->pemenang ? $item->pemenang->name : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
