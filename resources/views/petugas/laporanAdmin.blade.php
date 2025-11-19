@extends('layouts.dashboard')
@section('title', 'Laporan Admin')
@section('content')
    <div class="main-content">

        <div class="header">
            <h1>Laporan Lelang</h1>
        </div>

        {{-- Filter Pilih Petugas --}}
        <div class="card-box" style="margin-bottom: 20px;">
            <form action="{{ route('admin.laporan.filter') }}" method="post" class="search-box">
                @csrf
                <label for="petugas_id">Pilih Petugas:</label>
                <select name="petugas_id" required style="font-size:14px;margin:0 10px;">
                    <option value="">-- Pilih Petugas --</option>
                    @foreach ($petugas as $p)
                        <option value="{{ $p->id_petugas }}"
                            {{ isset($petugasId) && $petugasId == $p->id_petugas ? 'selected' : '' }}>
                            {{ $p->nama_petugas }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary">Tampilkan Laporan</button>
            </form>
        </div>

        {{-- Tabel Laporan --}}
        @if (count($laporan) > 0)
            <div class="card-box">
                <table class="table-dark">
                    <thead>
                        <tr>
                            <th>ID Lelang</th>
                            <th>Petugas</th>
                            <th>Barang</th>
                            <th>Tanggal Lelang</th>
                            <th>Harga Akhir</th>
                            <th>Pemenang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $row)
                            <tr>
                                <td>{{ $row->id_lelang }}</td>
                                <td>{{ $row->petugas->nama_petugas }}</td>
                                <td>{{ $row->barang->nama_barang }}</td>
                                <td>{{ $row->tgl_lelang }}</td>
                                <td>{{ number_format($row->harga_akhir) }} IDR</td>
                                <td>{{ $row->pemenang->name ?? '-' }}</td>
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
