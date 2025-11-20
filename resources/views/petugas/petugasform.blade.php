@extends('layouts.dashboard')
@section('title', 'Form User')
@section('content')
    <div class="main-content">
        <div class="header">
            <h1>
                {{ isset($petugas) ? 'Update Petugas' : 'Tambah Petugas' }}
            </h1>
        </div>

        <div class="card-box">
            <form
                action="{{ isset($petugas)
                    ? route('petugas.datapetugas.update', $petugas->id_petugas)
                    : route('petugas.datapetugas.store') }}"
                method="POST">
                @csrf
                @if (isset($petugas))
                    @method('PUT')
                @endif

                <label>Nama</label>
                <input type="text" style="font-size: 16px;width:98%" name="nama_petugas"
                    value="{{ old('nama_petugas', $petugas->nama_petugas ?? '') }}" required>

                <label>Username</label>
                <input type="text" style="font-size: 16px;width:98%" name="username"
                    value="{{ old('username', $petugas->username ?? '') }}" required>

                @if (!isset($petugas))
                    <label>Password</label>
                    <input type="password" style="font-size: 16px;width:98%" name="password" required>
                @else
                    <label>Password (kosongkan jika tidak diubah)</label>
                    <input type="password" style="font-size: 16px;width:98%" name="password">
                @endif
                @if (isset($petugas))
                    <div class="role-select" style="margin: 10px 0;">
                        <label style="font-weight: bold; display:block; margin-bottom: 6px;">
                            Pilih Level Pengguna:
                        </label>

                        <div style="display:flex; gap:20px; align-items:center;">
                            <div>
                                <input type="radio" id="admin" name="id_level" value="1"
                                    {{ old('id_level') == 1 ? 'checked' : '' }}>
                                <label for="admin">Admin</label>
                            </div>

                            <div>
                                <input type="radio" id="petugas" name="id_level" value="2"
                                    {{ old('id_level') == 2 ? 'checked' : '' }}>
                                <label for="petugas">Petugas</label>
                            </div>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="id_level" value="2">
                @endif
                <button type="submit" class="btn-primary mt-3">Simpan</button>
            </form>
        </div>
    @endsection
