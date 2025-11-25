<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Lelangku | Cetak Laporan</title>
    <link rel="icon" type="image/png" href="{{ asset('build/assets/images/auction_logo.jpg') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #000;
            background: #fff;
            margin: 40px;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 26px;
            color: #1f4b8f;
        }

        .header p {
            margin: 4px 0;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 13px;
        }

        th,
        td {
            border: 0.6px solid #000;
            padding: 8px 10px;
        }

        th {
            background-color: #d6eaff;
            color: #1a3a5f;
            text-align: center;
        }

        td {
            text-align: center;
            vertical-align: top;
        }

        .total-wrapper {
            margin-top: 25px;
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .total-box {
            border-top: 1px solid #000;
            padding-top: 10px;
            text-align: right;
            width: 320px;
        }

        .total-box label {
            font-weight: bold;
            font-size: 15px;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
                padding: 40px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="text-center">
            <img src="{{asset('build/assets/images/auction_logo.jpg')}}" alt="LelangKu" class="img-fluid" width="200" />
        </div>
        <h1>Laporan Pendapatan Lelang Petugas</h1>
        <hr>
    </div>

    <div class="info">
        <p><strong>Tanggal Cetak:</strong>
            {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
        <p><strong>Jumlah lelang:</strong> {{ $totallelang }} lelang</p>
        @if (!empty($tgl_lelang) && !empty($tanggal_akhir) && !empty($petugasTerpilih))
            <p><strong>Data Antara:</strong>
                {{ \Carbon\Carbon::parse($tgl_lelang)->translatedFormat('d F Y') }} -
                {{ \Carbon\Carbon::parse($tanggal_akhir)->translatedFormat('d F Y') }}
            </p>

            @php
                $pet = \App\Models\Petugas::find($petugasTerpilih);
            @endphp

            <p><strong>Petugas:</strong> {{ $pet->nama_petugas ?? 'Admin' }}</p>

        @elseif(!empty($tgl_lelang) && !empty($tanggal_akhir))
            <p><strong>Data Antara:</strong>
                {{ \Carbon\Carbon::parse($tgl_lelang)->translatedFormat('d F Y') }} -
                {{ \Carbon\Carbon::parse($tanggal_akhir)->translatedFormat('d F Y') }}
            </p>
            <p><strong>Semua Petugas</strong></p>

        @elseif(!empty($petugasTerpilih))
            @php
                $pet = \App\Models\Petugas::find($petugasTerpilih);
            @endphp

            <p><strong>Semua Data</strong></p>
            <p><strong>Petugas:</strong> {{ $pet->nama_petugas ?? 'Admin' }}</p>

        @else
            <p><strong>Semua Data</strong></p>
        @endif
        <p>Dokumen ini merupakan hasil cetak resmi yang disusun dan diverifikasi
            {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }}
        </p>
    </div>
    <table id="siswaTable">
        <thead>
            <tr>
                <th>No</th>
                <th class="d-none d-xl-table-cell">Nama Petugas</th>
                <th class="d-none d-xl-table-cell">Tanggal lelang</th>
                <th class="d-none d-xl-table-cell">Nama Barang</th>
                <th class="d-none d-xl-table-cell">Harga barang</th>
                <th class="d-none d-xl-table-cell">Harga Akhir</th>
                <th class="d-none d-xl-table-cell">Nama Bid</th>
                <th class="d-none d-xl-table-cell">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $lapo)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $lapo->petugas->nama_petugas ?? 'Data Dihapus' }}</td>
                    <td>{{ \Carbon\Carbon::parse($lapo->tgl_lelang)->format('d-m-Y') }}</td>
                    <td>{{ $lapo->barang->nama_barang }}</td>
                    <td>Rp. {{ number_format($lapo->barang->harga_awal, 0, ',', '.') }}</td>
                    <td>
                        @if($lapo->harga_bid_view)
                            Rp.{{ number_format($lapo->harga_bid_view, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $lapo->pemenang_view ?? '-' }}</td>
                    <td>{{ $lapo->status_view }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="total-wrapper">
        <div class="total-box">
            <label>Total Keseluruhan :</label><br>
            <strong>Rp {{ number_format($grandtotal, 0, ',', '.') }}</strong>
            <br>
            <br>
        </div>
    </div>
    <div class="total-wrapper">
        <div class="total-box">
            <label>Petugas : </label>
            <strong>
            @php
            $pet = \App\Models\Petugas::find($petugasId);
            @endphp
            <p>{{ $pet->nama_petugas ?? 'Admin' }}</p>
            </strong>
        </div>
    </div>
</body>

<script>
    const countdown = 1;
    function startCountdown() {
        let timeLeft = countdown;
        const countdownInterval = setInterval(() => {
            console.log(`Printing in ${timeLeft} seconds...`); 
            timeLeft--;
            if (timeLeft < 0) {
                clearInterval(countdownInterval);
                window.print();
            }
        }, 1000); 
    }
    window.onafterprint = function () {
        window.close(); 
    };
    window.onload = startCountdown;
</script>

</html>