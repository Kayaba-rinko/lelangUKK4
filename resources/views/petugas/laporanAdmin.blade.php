@extends('layouts.dashboard')
@section('title', 'Laporan Admin')
@section('content')
    <div class="main-content">

        <div class="header">
            <h1>Laporan Lelang</h1>
        </div>
            <div class="card-box" style="margin-bottom: 20px;">
                <label for="searchPetugas" style="font-size: 16px">Pilih Petugas</label>
                <form action="{{ route('admin.laporan.filter') }}" method="GET" id="filterForm" class="search-box" style="position: relative; width: auto;">
                    <input type="text" id="searchPetugas" style="width: -webkit-fill-available ;position:relative;" placeholder="Cari Nama Petugas..." autocomplete="off">
                    <input type="hidden" id="selected_petugas_id" name="petugas_id">
                    <ul id="resultList"></ul>
                    <button type="submit" class="btn-primary">Tampilkan Laporan</button>
                </form>
            </div>

        @if (isset($laporanPaginated) && $laporanPaginated->count() > 0)
            <div class="card-box">
                <div
                    class="header-card-box"style="display:flex; justify-content:space-between; align-items:center; gap:15px;">
                    <h2 style="margin:0; font-size:18px;">Total : Rp.{{ number_format($grandtotal) }}</h2>
                    <div style="display:flex; align-items:center; gap:15px;">
                        <a class="btn-primary" href="{{ route('petugas.cetak.laporan.admin', ['petugas_id' => $petugasId ?? '','tgl_lelang' => $tgl_lelang ?? '','tanggal_akhir' => $tgl_akhir ?? '',]) }}"style="font-size: 16px; padding:12px;">Cetak</a>
                        <form action="{{ route('admin.laporan.filter') }}" method="GET"class="search-box"style="display:flex; align-items:center; gap:10px;">
                            <label for="tgl_lelang" style="font-size:16px;">Dari:</label>
                            <input type="date" name="tgl_lelang"style="font-size:16px; padding:4px;"value="{{ $tgl_lelang ?? '' }}">
                            <label for="tanggal_akhir" style="font-size:16px;">Sampai:</label>
                            <input type="date" name="tanggal_akhir"style="font-size:16px; padding:4px;"value="{{ $tgl_akhir ?? '' }}">
                            <button type="submit" class="btn-search" style="padding:6px 10px;">Filter</button>
                        </form>
                    </div>
                </div>
                <table class="table-dark" id="dataTable">
                    <thead>
                        <tr>
                            <th>ID Lelang</th>
                            <th>Petugas</th>
                            <th>Tanggal Lelang</th>
                            <th>Nama Barang</th>
                            <th>Harga Barang</th>
                            <th>Pemenang</th>
                            <th>Harga Bid</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporanPaginated as $row)
                            <tr>
                                <td>{{ $row->id_lelang }}</td>
                                <td>{{ $row->petugas->nama_petugas ?? 'Tidak Terdata' }}</td>
                                <td>{{ $row->tgl_lelang }}</td>
                                <td>{{ $row->barang->nama_barang }}</td>
                                <td>Rp.{{ number_format($row->barang->harga_awal) }}</td>
                                <td>
                                    @if ($row->status_view == 'DIBUKA')
                                        -
                                    @else
                                        {{ $row->pemenang_view ?? '-' }}
                                    @endif
                                </td>
                                <td>
                                    @if ($row->status_view == 'SELESAI')
                                        Rp.{{ number_format($row->harga_bid_view) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $row->status_view }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="text-align: center; margin-top: 20px;">
                    {{ $laporanPaginated->appends(request()->query())->links('vendor.pagination.default') }}
                </div>
            </div>
        @else
            <p style="text-align:center; opacity:0.7;">Belum ada data laporan ditemukan.</p>
        @endif
    </div>
    <script>
    const petugasData = @json($petugas);
    const searchInput = document.getElementById("searchPetugas");
    const resultList = document.getElementById("resultList");
    const hiddenInput = document.getElementById("selected_petugas_id");

    searchInput.addEventListener("input", function() {
        const keyword = this.value.toLowerCase();
        resultList.innerHTML = "";

        if (keyword.trim() !== "") {
            const filtered = petugasData.filter(p =>
                p.nama_petugas.toLowerCase().includes(keyword)
            );

            if (filtered.length > 0) {
                resultList.style.display = "block";
                filtered.forEach(item => {
                    const li = document.createElement("li");
                    li.textContent = item.nama_petugas;
                    li.dataset.id = item.id_petugas;
                    li.addEventListener("click", () => {
                        searchInput.value = item.nama_petugas;
                        hiddenInput.value = item.id_petugas;
                        resultList.style.display = "none";
                        document.getElementById("filterForm").submit();
                    });
                    resultList.appendChild(li);
                });
            } else {
                resultList.style.display = "none";
            }
        } else {
            resultList.style.display = "none";
        }
    });

    document.addEventListener("click", function(e){
        if (!searchInput.contains(e.target))
            resultList.style.display = "none";
    });
</script>


@endsection
