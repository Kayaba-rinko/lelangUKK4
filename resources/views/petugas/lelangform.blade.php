@extends('layouts.dashboard')
@section('title', isset($data) ? 'Edit Lelang' : 'Tambah Lelang')

@section('content')
<div class="main-content">
    <div class="header">
        <h1>{{ isset($data) ? 'Edit Lelang' : 'Tambah Lelang' }}</h1>
    </div>

    <div class="card-box">
    <form action="{{ isset($data) ? route('petugas.bukaTutup.update', $data->id_lelang) : route('petugas.bukaTutup.store') }}" method="POST">
        @csrf
        @if(isset($data))
            @method('PUT')
        @endif
        <label>Pilih Barang</label>
        <div class="search-box" style="position: relative; width:95%; margin-bottom: 10px;">
            <input type="text" style="width: -webkit-fill-available;" id="searchBarang" placeholder="Cari barang..." class="search-input"value="{{ isset($data) ? $data->barang->nama_barang : '' }}">
            <input type="hidden" name="id_barang" id="id_barang" value="{{ isset($data) ? $data->id_barang : '' }}">
            <ul id="barangDropdown" class="dropdown-list"></ul>
        </div>
        <label>Tanggal Mulai</label>
        <input type="date" style="font-size: 16px;width:95%"name="tgl_lelang"value="{{ isset($data) ? $data->tgl_lelang : now()->format('Y-m-d') }}"required>
        <br>
        <label>Tanggal Akhir</label>
        <input type="date" style="font-size:16px;width:95%"name="tanggal_akhir"value="{{ old('tanggal_akhir', $data->tanggal_akhir ?? '') }}"required>
        <br>
        <label>Harga Awal</label>
        <input type="number" style="font-size:16px;width:95%"name="harga_awal"value="{{ old('harga_awal', $data->harga_awal ?? '') }}"required>
        <input type="hidden" name="id_petugas" value="{{ Auth::guard('petugas')->id() }}">
        <input type="hidden" name="status" value="{{ isset($data) ? $data->status : 'dibuka' }}">
        <button type="submit" class="btn-primary mt-3">Simpan</button>
    </form>

    </div>
</div>
<script>
    const barangData = @json($barang);

    const searchInput = document.getElementById("searchBarang");
    const dropdown = document.getElementById("barangDropdown");
    const idHidden = document.getElementById("id_barang");
    const hargaAwalInput = document.querySelector('input[name="harga_awal"]');

    searchInput.addEventListener("keyup", function () {
        let keyword = this.value.toLowerCase();
        dropdown.innerHTML = "";

        if (keyword.length === 0) {
            dropdown.style.display = "none";
            return;
        }

        let filtered = barangData.filter(item =>
            item.nama_barang.toLowerCase().includes(keyword)
        );

        if (filtered.length > 0) {
            dropdown.style.display = "block";
            filtered.forEach(item => {
                let li = document.createElement("li");
                li.textContent = item.nama_barang + " - Rp " +
                    new Intl.NumberFormat('id-ID').format(item.harga_awal);
                li.setAttribute("data-id", item.id_barang);

                li.addEventListener("click", function () {
                    searchInput.value = item.nama_barang;
                    idHidden.value = item.id_barang;
                    hargaAwalInput.value = item.harga_awal;
                    dropdown.style.display = "none";
                });

                dropdown.appendChild(li);
            });
        } else {
            dropdown.innerHTML = `<li class="no-result">Tidak ditemukan</li>`;
            dropdown.style.display = "block";
        }
    });

    // Hide dropdown when clicking outside
    document.addEventListener("click", function (e) {
        if (!dropdown.contains(e.target) && e.target !== searchInput) {
            dropdown.style.display = "none";
        }
    });
</script>
@endsection
