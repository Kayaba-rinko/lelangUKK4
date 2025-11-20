@extends('layouts.dashboard')
@section('title', 'Data Petugas')
@section('content')
    <div class="main-content">
        <div class="header">
            <h1>Data Petugas</h1>
            <div class="header-right">
                <form action="{{ route('petugas.petugas.cari') }}" class="search-box">
                    <input style="font-size: 14px" type="text" name="cari" placeholder="Cari Petugas..." value="{{ request('cari') }}">
                    <button type="submit" class="btn-search">🔍</button>
                </form>
                <a href="{{ route('petugas.datapetugas.create') }}" class="btn-primary tambah-btn">Tambah Petugas</a>
            </div>
        </div>

        <div class="card-box">
            <table class="table-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($petugas as $user)
                    <tr>
                        <td>{{ $user->id_petugas }}</td>
                        <td>{{ $user->nama_petugas }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->id_level }}</td>
                        <td>
                            <a href="{{ route('petugas.datapetugas.edit', $user->id_petugas) }}" class="btn-primary">Edit</a>
                            <form action="{{ route('petugas.datapetugas.destroy', $user->id_petugas) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus?')" class="btn-primary">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection