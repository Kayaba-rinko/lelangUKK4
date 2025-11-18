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
                <input type="text" name="nama_petugas" value="{{ old('nama_petugas', $petugas->nama_petugas ?? '') }}" required>

                <label>Username</label>
                <input type="text" name="username" value="{{ old('username', $petugas->username ?? '') }}" required>

                @if (!isset($petugas))
                    <label>Password</label>
                    <input type="password" name="password" required>
                @else
                    <label>Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password">
                @endif
                <input type="hidden" name="id_level" value="2">
                <button type="submit" class="btn-primary mt-3">Simpan</button>
            </form>
        </div>
    @endsection
