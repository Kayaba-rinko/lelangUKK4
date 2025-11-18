@extends('layouts.dashboard')
@section('title', 'Data Barang')
@section('content')
    <div class="main-content">
        <div class="header">
            <h1>Data Barang</h1>
            <a href="{{ route('petugas.barangdata.create') }}" class="btn-primary">Tambah Barang</a>
        </div>

        <div class="card-box">
            <table class="table-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Masuk</th>
                        <th>Harga Awal</th>
                        <th>Gambar</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $item)
                        <tr>
                            <td>{{ $item->id_barang }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->tgl_masuk }}</td>
                            <td>{{ $item->harga_awal }}</td>
                            <td>
                                @if ($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="" width="70">
                                @else
                                    Tidak ada gambar
                                @endif
                            </td>
                            <td>{{ $item->deskripsi_barang }}</td>
                            <td>
                                <a href="{{ route('petugas.barangdata.edit', $item->id_barang) }}"
                                    class="btn-primary">Edit</a>

                                <form action="{{ route('petugas.barangdata.destroy', $item->id_barang) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus?')"
                                        class="btn-primary">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
