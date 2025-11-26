@extends('layouts.dashboard')
@section('title', 'Laporan Petugas')
@section('content')
    <div class="main-content">
        <div class="header">
            <h1>Laporan Lelang Petugas</h1>
            <div class="header-right">
                <div class="unified-print-bar">
                    <form action="{{ route('petugas.cetak.laporan.tanggal') }}" method="GET" class="print-filter-form">
                        <div class="input-group">
                            <label for="tgl_lelang">Dari:</label>
                            <input type="date" name="tgl_lelang" value="{{ request('tgl_lelang') ?? ($tgl_lelang ?? '') }}" required>
                        </div>
                        <div class="input-group">
                            <label for="tanggal_akhir">Sampai:</label>
                            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') ?? ($tanggal_akhir ?? '') }}" required>
                        </div>
                        <button type="submit" class="btn-search small-btn">Filter</button>
                    </form>
                    <div class="vertical-sep"></div>
                    <a href="{{ route('petugas.cetak.laporan') }}" class="btn-primary btn-cetak">Cetak Laporan</a>
                </div>
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
