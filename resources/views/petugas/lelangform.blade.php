@extends('layouts.dashboard')
@section('title', isset($data) ? 'Edit Lelang' : 'Tambah Lelang')

@section('content')
<div class="main-content">
    <div class="header">
        <h1>{{ isset($data) ? 'Edit Lelang' : 'Tambah Lelang' }}</h1>
    </div>

    <div class="card-box">
        <form action="{{ isset($data) ? route('petugas.bukaTutup.update', $data->id_lelang) : route('petugas.bukaTutup.store') }}"
              method="POST">
            @csrf
            @if(isset($data))
                @method('PUT')
            @endif
            <label>Pilih Barang</label>
            <select name="id_barang" required>
                <option value="" disabled selected>Pilih Barang</option>
                @foreach($barang as $b)
                    <option value="{{ $b->id_barang }}"{{ isset($data) && $data->id_barang == $b->id_barang ? 'selected' : '' }}>{{ $b->nama_barang }}
                    </option>
                @endforeach
            </select>
            <label>Tanggal Mulai</label>
            <input type="date" name="tgl_lelang"value="{{ old('tgl_lelang', $data->tgl_lelang ?? now()->toDateString()) }}" required>
            <label>Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir"value="{{ old('tanggal_akhir', $data->tanggal_akhir ?? '') }}"required>
            <label>Harga Awal</label>
            <input type="number" name="harga_awal"value="{{ old('harga_awal', $data->harga_awal ?? '') }}"required>
            <input type="hidden" name="id_petugas" value="{{ Auth::guard('petugas')->id() }}">
            <input type="hidden" name="status" value="{{ isset($data) ? $data->status : 'dibuka' }}">
            <button type="submit" class="btn-primary mt-3">Simpan</button>
        </form>
    </div>
</div>
@endsection
