@extends('layouts.dashboard')
@section('title', 'Buka & Tutup Lelang')

@section('content')
    <div class="main-content">

        <div class="header">
            <h1>Buka & Tutup Lelang</h1>
            <div class="header-right">
                <form action="{{ route('petugas.bukaTutup.cari') }}" class="search-box">
                    <input style="font-size: 14px" type="text" name="cari" placeholder="Cari Lelang..." value="{{ request('cari') }}">
                    <button type="submit" class="btn-search">🔍</button>
                </form>
                <a href="{{ route('petugas.bukaTutup.create') }}" class="btn-primary">Tambah Lelang</a>
            </div>
        </div>

        <div class="card-box">
            <table class="table-dark">
                <thead>
                    <tr>
                        <th>ID Lelang</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Harga Awal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($lelang as $lelangu)
                        <tr>
                            <td>{{ $lelangu->id_lelang }}</td>
                            <td>{{ $lelangu->barang->nama_barang }}</td>
                            <td>{{ $lelangu->tgl_lelang }}</td>
                            <td>{{ $lelangu->tanggal_akhir }}</td>
                            <td>{{ number_format($lelangu->harga_awal) }}</td>
                            <td>{{ ucfirst($lelangu->status) }}</td>
                            <td>
                                <a
                                    href="{{ route('petugas.bukaTutup.edit', $lelangu->id_lelang) }}"class="btn-primary">Edit</a>
                                <form action="{{ route('petugas.bukaTutup.destroy', $lelangu->id_lelang) }}"
                                    method="POST"style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        onclick="return confirm('Yakin ingin menghapus lelang ini?')"class="btn-primary">Hapus</button>
                                </form>
                                @if ($lelangu->status === 'dibuka')
                                    <form action="{{ route('petugas.bukaTutup.tutup', $lelangu->id_lelang) }}"method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <button onclick="return confirm('Yakin ingin menutup lelang ini?')"class="btn-primary">Tutup</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
