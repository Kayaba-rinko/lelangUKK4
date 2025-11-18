@extends('layouts.dashboard')
@section('title', 'Form Barang')
@section('content')
    <div class="main-content">
        <div class="header">
            <h1>
                {{ isset($barang) ? 'Update Barang' : 'Tambah Barang' }}
            </h1>
        </div>

        <div class="card-box">
            <form
                action="{{ isset($barang) ? route('petugas.barangdata.update', $barang->id_barang) : route('petugas.barangdata.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($barang))
                    @method('PUT')
                @endif

                <label>Nama Barang</label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang ?? '') }}" required>

                <label>Harga Awal</label>
                <input type="number" name="harga_awal" value="{{ old('harga_awal', $barang->harga_awal ?? '') }}" required>
                @if (!isset($barang))
                <label>Tanggal Masuk</label>
                <input type="date" value="{{ now()->format('Y-m-d') }}" disabled>
                <input type="hidden" name="tgl_masuk" value="{{ now()->format('Y-m-d') }}">
                @else
                <label>Tanggal Masuk</label>
                    <input type="date" value="{{ now()->format('Y-m-d') }}" disabled>
                    <input type="hidden" name="tgl_masuk" value="{{ now()->format('Y-m-d') }}">
                @endif

                <label>Deskripsi</label>
                <textarea name="deskripsi_barang" required>{{ old('deskripsi_barang', $barang->deskripsi_barang ?? '') }}</textarea>

                <label>Gambar</label>
                <input type="file" name="gambar" {{ isset($barang) ? '' : 'required' }}>

                <button type="submit" class="btn-primary mt-3">Simpan</button>
            </form>
        </div>
    @endsection
