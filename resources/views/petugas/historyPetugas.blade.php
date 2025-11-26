@extends('layouts.dashboard')
@section('title', 'History Lelang')
@section('content')
    <div class="main-content">
        <div class="header">
            <h1>History Lelang Petugas</h1>
            <div class="header-actions">
                <div class="unified-filter-bar">
                    <form action="{{ route('petugas.historyPetugas.cari') }}" class="filter-section">
                        <input type="text" name="cari" placeholder="Cari History..." value="{{ request('cari') }}">
                        <button type="submit" class="btn-search icon-btn">🔍</button>
                    </form>
                    <div class="vertical-sep"></div>
                    <form action="{{ route('petugas.historyPetugas.filter') }}" method="GET" class="filter-section date-section">
                        <div class="input-group">
                            <label for="tgl_lelang">Dari:</label>
                            <input type="date" name="tgl_lelang" value="{{ request('tgl_lelang') ?? ($tgl_lelang ?? '') }}" required>
                        </div>
                        <div class="input-group">
                            <label for="tanggal_akhir">Sampai:</label>
                            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') ?? ($tanggal_akhir ?? '') }}" required>
                        </div>
                        <button type="submit" class="btn-search">Filter</button>
                    </form>
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
                            <td>Rp.{{ number_format($item->harga_akhir) }}</td>
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
            <div style="text-align: center; margin-top: 20px;">
                @if (isset($cari) || isset($tgl_lelang))
                    {{ $lelang->appends(request()->query())->links('vendor.pagination.default') }}
                @else
                    {{ $lelang->links('vendor.pagination.default') }}
                @endif
            </div>
        </div>
    </div>
@endsection
