@extends('layouts.dashboard')
@section('title','Dashboard Petugas')
@section('content')
<link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
<div class="main-content">

    <div class="header">
        <h1>Dashboard Petugas</h1>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>

        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    {{-- TOP STATS (Grid 3 Kolom) --}}
    <div class="dashboard-home-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">

        <a href="{{ route('petugas.barangdata') }}" class="stat-card-new">
            <div class="stat-icon-box" style="background: rgba(241, 196, 15, 0.15); color: #f1c40f;">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="stat-details">
                <h4>Total Barang</h4>
                <p class="stat-number">{{ $totalBarang }}</p>
                <div class="stat-trend up">Inventory System</div>
            </div>
        </a>

        <a href="{{ route('petugas.bukaTutup') }}" class="stat-card-new">
            <div class="stat-icon-box" style="background: rgba(52, 152, 219, 0.15); color: #3498db;">
                <i class="fas fa-hammer"></i>
            </div>
            <div class="stat-details">
                <h4>Lelang Anda</h4>
                <p class="stat-number">{{ $totalLelangPetugas }}</p>
                <div class="stat-trend up">Dikelola</div>
            </div>
        </a>

        <a href="{{ route('laporan.petugas') }}" class="stat-card-new">
            <div class="stat-icon-box" style="background: rgba(46, 204, 113, 0.15); color: #2ecc71;">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-details">
                <h4>Pendapatan Sukses</h4>
                <p class="stat-number" style="font-size: 20px;">Rp {{ number_format($totalPendapatan) }}</p>
                <div class="stat-trend up">Total Terjual</div>
            </div>
        </a>

    </div>

    {{-- CHARTS SECTION --}}
    <div class="charts-section">

        <div class="chart-card">
            <div class="chart-header">
                <h3>Statistik Kinerja Lelang</h3>
            </div>
            <div style="height: 300px; width: 100%;">
                <canvas id="chartPetugasBar"></canvas>
            </div>
        </div>

        <div class="chart-card" style="display: flex; flex-direction: column; justify-content: center;">
            <div class="chart-header">
                <h3>Ringkasan</h3>
            </div>
            <div style="text-align: center; margin-top: 10px;">
                <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #6c5ce7, #a29bfe); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; box-shadow: 0 0 20px rgba(108, 92, 231, 0.4);">
                    <i class="fas fa-trophy" style="font-size: 40px; color: white;"></i>
                </div>
                <h2 style="margin:0; color: white;">{{ $totalLelangPetugas }}</h2>
                <p style="color: #aaa; font-size: 14px;">Total Lelang Ditangani</p>
                <hr style="border: 0; border-top: 1px solid #333; margin: 20px 0;">
                <p style="color: #888; font-size: 13px;">Pertahankan kinerja Anda untuk meningkatkan pendapatan lelang.</p>
            </div>
        </div>
    </div>
    <div class="recent-orders-wrapper">
        <div class="recent-header">
            <h3>Lelang Tertinggi (Top Bids)</h3>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th width="40%">Barang</th>
                    <th width="20%">Tanggal</th>
                    <th width="25%">Harga Saat Ini</th>
                    <th width="15%">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topLelang as $item)
                <tr>
                    <td>
                        <div class="product-cell">
                            <img src="{{ asset('storage/' . $item->barang->gambar) }}"  alt="img" class="product-img">
                            <div class="product-info">
                                <h5>{{ $item->barang->nama_barang }}</h5>
                                <small>{{ Str::limit($item->barang->deskripsi_barang, 20) }}</small>
                            </div>
                        </div>
                    </td>
                    <td style="color: #ccc;">
                        {{ \Carbon\Carbon::parse($item->tgl_lelang)->format('d M Y') }}
                    </td>
                    <td style="font-weight: bold; color: #a29bfe;">
                        Rp {{ number_format($item->harga_akhir) }}
                    </td>
                    <td>
                        @if($item->status == 'dibuka')
                            <span class="status-badge success">Dibuka</span>
                        @else
                            <span class="status-badge danger">Ditutup</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #888; padding: 20px;">
                        Tidak ada data lelang.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
<script>
    const ctx = document.getElementById('chartPetugasBar').getContext('2d');
    const monthNames = ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

    const labels = [
        @foreach($chartData as $lb)
            monthNames[{{ $lb->bulan }}],
        @endforeach
    ];

    const dataVal = [
        @foreach($chartData as $lb)
            {{ $lb->total }},
        @endforeach
    ];

    let gradientBlue = ctx.createLinearGradient(0, 0, 0, 400);
    gradientBlue.addColorStop(0, '#3498db');
    gradientBlue.addColorStop(1, '#2980b9');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Lelang Dibuat',
                data: dataVal,
                backgroundColor: gradientBlue,
                borderRadius: 5,
                barPercentage: 0.5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#888' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#888' }
                }
            }
        }
    });
</script>

@endsection