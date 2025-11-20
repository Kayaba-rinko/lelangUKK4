@extends('layouts.dashboard')
@section('title', 'Data User')
@section('content')
    <div class="main-content">
        <div class="header">
            <h1>Data User</h1>
            <div class="header-right">
                <form action="{{ route('petugas.userdata.cari') }}" class="search-box">
                    <input style="font-size: 14px" type="text" name="cari" placeholder="Cari Petugas..."value="{{ request('cari') }}">
                    <button type="submit" class="btn-search">🔍</button>
                </form>
                <a href="{{ route('petugas.userdata.create') }}" class="btn-primary tambah-btn">Tambah User</a>
            </div>
        </div>

        <div class="card-box">
            <table class="table-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($masyarakat as $user)
                        <tr>
                            <td>{{ $user->id_masyarakat }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->alamat }}</td>
                            <td>{{ $user->telp }}</td>
                            <td>{{ $user->status }}</td>
                            <td>
                                <a href="{{ route('petugas.userdata.edit', $user->id_masyarakat) }}"class="btn-primary">Edit</a>
                                <form action="{{ route('petugas.userdata.destroy', $user->id_masyarakat) }}" method="POST"style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus?')"class="btn-primary">Hapus</button>
                                </form>
                                @if ($user->status === 'aktif')
                                    <form action="{{ route('petugas.userdata.blokir', $user->id_masyarakat) }}"method="POST" style="display:inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn-primary">Blokir</button>
                                    </form>
                                @else
                                    <form action="{{ route('petugas.userdata.aktifkan', $user->id_masyarakat) }}"method="POST" style="display:inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn-primary">Aktifkan</button>
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
