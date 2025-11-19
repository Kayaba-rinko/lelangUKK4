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
            <br>
            <select name="id_barang" style="font-size:16px;width:96.5%" required>
                <option value="" disabled selected>Pilih Barang</option>
                @foreach($barang as $b)
                    <option value="{{ $b->id_barang }}"{{ isset($data) && $data->id_barang == $b->id_barang ? 'selected' : '' }}>{{ $b->nama_barang }}
                    </option>
                @endforeach
            </select>
            <br>
            <label>Tanggal Mulai</label>
            <input type="date" style="font-size: 16px;width:95%" name="tgl_lelang"value="{{ now()->format('Y-m-d') }}" required>
            <br>
            <label>Tanggal Akhir</label>
            <input type="date" style="font-size:16px;width:95%"name="tanggal_akhir"value="{{ old('tanggal_akhir', $data->tanggal_akhir ?? '') }}"required>
            <br>
            <label>Harga Awal</label>
            <input type="number" style="font-size:16px;width:95%" name="harga_awal"value="{{ old('harga_awal', $data->harga_awal ?? '') }}"required>
            <input type="hidden" name="id_petugas" value="{{ Auth::guard('petugas')->id() }}">
            <input type="hidden" name="status" value="{{ isset($data) ? $data->status : 'dibuka' }}">
            <button type="submit" class="btn-primary mt-3">Simpan</button>
        </form>
    </div>
</div>
<script>
    // harga barang berganti ketika barang dipilih
    const barangSelect = document.querySelector('select[name="id_barang"]');
    const hargaAwalInput = document.querySelector('input[name="harga_awal"]');
    const barangData = @json($barang->mapWithKeys(function($item) {
        return [$item->id_barang => $item->harga_awal];
    }));
    barangSelect.addEventListener('change', function() {
        const selectedBarangId = this.value;
        if (barangData[selectedBarangId]) {
            hargaAwalInput.value = barangData[selectedBarangId];
        } else {
            hargaAwalInput.value = '';
        }
    });
</script>
@endsection
