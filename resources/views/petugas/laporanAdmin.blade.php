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
                <div class="unified-total-bar">
                    <div class="total-section">
                        <span class="label">Total :</span>
                        <span class="amount">Rp.{{ number_format($grandtotal) }}</span>
                    </div>
                    <div class="vertical-sep"></div>
                    <form action="{{ route('admin.laporan.filter') }}" method="GET" class="filter-section">
                        <div class="input-group">
                            <label for="tgl_lelang">Dari:</label>
                            <input type="date" name="tgl_lelang" value="{{ $tgl_lelang ?? '' }}">
                        </div>
                        <div class="input-group">
                            <label for="tanggal_akhir">Sampai:</label>
                            <input type="date" name="tanggal_akhir" value="{{ $tgl_akhir ?? '' }}">
                        </div>
                        <button type="submit" class="btn-search small-btn">Filter</button>
                    </form>
                    <div class="vertical-sep"></div>
                    <a href="{{ route('petugas.cetak.laporan.admin', [
                        'petugas_id'   => $petugasId ?? '',
                        'tgl_lelang'   => $tgl_lelang ?? '',
                        'tanggal_akhir'=> $tanggal_akhir ?? '',
                    ]) }}" class="btn-primary btn-cetak">
                        Cetak Laporan
                    </a>
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
