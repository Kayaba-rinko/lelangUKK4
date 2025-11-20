@extends('layouts.dashboard')
@section('title', 'Form User')
@section('content')
    <div class="main-content">
        <div class="header">
            <h1>{{ isset($masyarakat) ? 'Update Masyarakat' : 'Tambah Masyarakat' }}</h1>
        </div>

        <div class="card-box">
            <form action="{{ isset($masyarakat) ? route('petugas.userdata.update', $masyarakat->id_masyarakat) : route('petugas.userdata.store') }}"method="POST">
                @csrf
                @if (isset($masyarakat))
                @method('PUT')
                @endif
                <label>Nama</label>
                <input type="text" style="font-size: 16px;width:98%" name="name" value="{{ old('name', $masyarakat->name ?? '') }}" required>
                <label>NIK</label>
                <input type="text" style="font-size: 16px;width:98%" maxlength="16" minlength="16" name="username" value="{{ old('username', $masyarakat->username ?? '') }}" required>
                <label>Alamat</label>
                <input type="text" style="font-size: 16px;width:98%" name="alamat" value="{{ old('alamat', $masyarakat->alamat ?? '') }}">
                <label>Telepon</label>
                <input type="text" style="font-size: 16px;width:98%" name="telp" value="{{ old('telp', $masyarakat->telp ?? '') }}">
                @if (!isset($masyarakat))
                    <label>Password</label>
                    <input type="password" style="font-size: 16px;width:98%" name="password" required>
                @else
                    <input type="hidden" name="password" value="{{ $masyarakat->password }}">
                @endif
                <button type="submit" class="btn-primary mt-3">Simpan</button>
            </form>
        </div>
    @endsection
