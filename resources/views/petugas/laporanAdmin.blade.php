@extends('layouts.dashboard')
@section('title', 'Laporan Admin')
@section('content')
    <div class="main-content">

        <div class="header">
            <h1>Laporan Lelang</h1>
        </div>

        <div class="card-box" style="margin-bottom: 20px;">
            <form action="{{ route('admin.laporan.filter') }}" method="post" class="search-box">
                @csrf
                <label for="petugas_id">Pilih Petugas:</label>
                <select name="petugas_id" style="font-size:14px;margin:0 10px;">
                    <option value="">-- Semua Petugas --</option>
                    @foreach ($petugas as $p)
                        <option value="{{ $p->id_petugas }}"{{ isset($petugasId) && $petugasId == $p->id_petugas ? 'selected' : '' }}>{{ $p->nama_petugas }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary">Tampilkan Laporan</button>
            </form>
        </div>


        @if ($laporan)
            <div class="card-box">
                <div class="header-card-box"style="display:flex; justify-content:space-between; align-items:center; gap:15px;">
                    <h2 style="margin:0; font-size:18px;">Total : {{ number_format($grandtotal) }}</h2>
                    <div style="display:flex; align-items:center; gap:15px;">
                        <a class="btn-primary"href="{{ route('petugas.cetak.laporan.admin', ['petugas_id' => $petugasId ?? '','tgl_lelang' => $tgl_lelang ?? '','tanggal_akhir' => $tanggal_akhir ?? '', ]) }}"style="font-size: 16px; padding:12px;">Cetak</a>
                        <form action="{{ route('admin.laporan.filter') }}" method="GET"
                            class="search-box"style="display:flex; align-items:center; gap:10px;">
                            <label for="tgl_lelang" style="font-size:14px;">Dari:</label>
                            <input type="date" name="tgl_lelang"style="font-size:14px; padding:4px;"value="{{ request('tgl_lelang') ?? ($tgl_lelang ?? '') }}">
                            <label for="tanggal_akhir" style="font-size:14px;">Sampai:</label>
                            <input type="date" name="tanggal_akhir"style="font-size:14px; padding:4px;"value="{{ request('tanggal_akhir') ?? ($tanggal_akhir ?? '') }}">
                            <button type="submit" class="btn-search" style="padding:6px 10px;">Filter</button>
                        </form>
                    </div>
                </div>
                <table class="table-dark">
                    <thead>
                        <tr>
                            <th>ID Lelang</th>
                            <th>Petugas</th>
                            <th>Tanggal Lelang</th>
                            <th>Nama Barang</th>
                            <th>Harga Barang</th>
                            <th>Pemenang</th>
                            <th>Harga Bid</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $row)
                            <tr>
                                <td>{{ $row->id_lelang }}</td>
                                <td>{{ $row->petugas->nama_petugas ?? 'Tidak Terdata' }}</td>
                                <td>{{ $row->tgl_lelang }}</td>
                                <td>{{ $row->barang->nama_barang }}</td>
                                <td>IDR {{ number_format($row->barang->harga_awal) }}</td>
                                <td>
                                    @if ($row->status_view == 'DIBUKA')
                                        -
                                    @else
                                        {{ $row->pemenang->name ?? '-' }}
                                    @endif
                                </td>
                                <td>
                                    @if ($row->status_view == 'SELESAI')
                                        IDR {{ number_format($row->harga_bid_view) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $row->status_view }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align:center; opacity:0.7;">Belum ada data laporan ditemukan.</p>
        @endif

    </div>
@endsection
