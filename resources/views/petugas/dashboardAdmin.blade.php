@extends('layouts.dashboard')
@section('title','Dashboard Admin')
@section('content')
<link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
<div class="main-content">
    <div class="header">
        <h1>Dashboard Admin</h1>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>

        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    {{-- TOP ROW: STATS CARDS (Grid 4 Kolom) --}}
    <div class="dashboard-home-grid">

        <a href="{{ route('petugas.userdata') }}" class="stat-card-new">
            <div class="stat-icon-box" style="background: rgba(52, 152, 219, 0.15); color: #3498db;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-details">
                <h4>Masyarakat</h4>
                <p class="stat-number">{{ $totalUser }}</p>
                <div class="stat-trend up">
                    <i class="fas fa-check-circle"></i> Terdaftar
                </div>
            </div>
        </a>

        <a href="{{ route('petugas.datapetugas') }}" class="stat-card-new">
            <div class="stat-icon-box" style="background: rgba(155, 89, 182, 0.15); color: #9b59b6;">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-details">
                <h4>Petugas</h4>
                <p class="stat-number">{{ $totalPetugas }}</p>
                <div class="stat-trend">
                    <i class="fas fa-user-tie"></i> Aktif
                </div>
            </div>
        </a>

        <a href="{{ route('petugas.barangdata') }}" class="stat-card-new">
            <div class="stat-icon-box" style="background: rgba(46, 204, 113, 0.15); color: #2ecc71;">
                <i class="fas fa-box-open"></i>
            </div>
            <div class="stat-details">
                <h4>Total Barang</h4>
                <p class="stat-number">{{ $totalBarang }}</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i> Data Tersedia
                </div>
            </div>
        </a>

        <a href="{{ route('laporan.admin') }}" class="stat-card-new">
            <div class="stat-icon-box" style="background: rgba(231, 76, 60, 0.15); color: #e74c3c;">
                <i class="fas fa-gavel"></i>
            </div>
            <div class="stat-details">
                <h4>Total Lelang</h4>
                <p class="stat-number">{{ $totalLelang }}</p>
                <div class="stat-trend up">
                    <i class="fas fa-chart-line"></i> Transaksi
                </div>
            </div>
        </a>

    </div>

    {{-- MIDDLE ROW: CHARTS SECTION --}}
    <div class="charts-section">

        <div class="chart-card">
            <div class="chart-header">
                <h3>Aktivitas Lelang Bulanan</h3>
                <i class="fas fa-ellipsis-v" style="color: #666; cursor: pointer;"></i>
            </div>
            <div style="height: 300px; width: 100%;">
                <canvas id="barChartAdmin"></canvas>
            </div>
        </div>

        <div class="chart-card target-card">
            <div class="chart-header" style="width: 100%;">
                <h3>Total Pendapatan</h3>
                <i class="fas fa-ellipsis-v" style="color: #666;"></i>
            </div>
            
            <div style="height: 200px; width: 100%; position: relative; display: flex; justify-content: center;">
                <canvas id="gaugeChart"></canvas>
                <div style="position: absolute; top: 60%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                    <span style="font-size: 20px; font-weight: bold; color: #fff;">IDR</span>
                </div>
            </div>

            <div class="target-info">
                <h2>Rp {{ number_format($totalPendapatan / 1000000, 1) }} Jt</h2>
                <p>Total akumulasi pendapatan lelang yang telah selesai.</p>
                <div style="margin-top: 15px; display: flex; justify-content: center; gap: 20px;">
                    <div>
                        <small style="color: #aaa;">Target</small><br>
                        <span style="color: #ff7675; font-weight: bold;">Dynamic <i class="fas fa-arrow-down"></i></span>
                    </div>
                    <div>
                        <small style="color: #aaa;">Revenue</small><br>
                        <span style="color: #55efc4; font-weight: bold;">Rp {{ number_format($totalPendapatan) }} <i class="fas fa-arrow-up"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="recent-orders-wrapper">
        <div class="recent-header">
            <h3>Riwayat Penawaran Terbaru</h3>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th width="35%">Barang</th>
                    <th width="25%">Penawar</th>
                    <th width="20%">Harga Tawaran</th>
                    <th width="20%">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBids as $bid)
                <tr>
                    <td>
                        <div class="product-cell">
                            <img src="{{ asset('storage/' . $bid->barang->gambar) }}"  alt="img" class="product-img">
                            <div class="product-info">
                                <h5>{{ $bid->lelang->barang->nama_barang }}</h5>
                                <small>ID: #{{ $bid->lelang->id_lelang }}</small>
                            </div>
                        </div>
                    </td>
                    <td style="color: #ccc;">
                        {{ $bid->masyarakat->name ?? 'User Terhapus' }}
                    </td>
                    <td style="font-weight: bold; color: #fff;">
                        Rp {{ number_format($bid->penawaran_harga) }}
                    </td>
                    <td>
                        <span class="status-badge success">Bid Masuk</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #888; padding: 20px;">
                        Belum ada aktivitas penawaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="{{ asset('js/chart.js') }}"></script>
<script>
    const ctxBar = document.getElementById('barChartAdmin').getContext('2d');
    const monthNames = ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
    const rawLabels = [
        @foreach($chartData as $lb)
            {{ $lb->bulan }},
        @endforeach
    ];
    const dataValues = [
        @foreach($chartData as $lb)
            {{ $lb->total }},
        @endforeach
    ];
    const labels = rawLabels.map(m => monthNames[m]);
    let gradient = ctxBar.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, '#8e44ad');
    gradient.addColorStop(1, '#6c5ce7');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Lelang',
                data: dataValues,
                backgroundColor: gradient,
                borderRadius: 5, 
                barPercentage: 0.6, 
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#2c2c2c',
                    titleColor: '#fff',
                    bodyColor: '#ccc',
                    borderColor: '#444',
                    borderWidth: 1,
                    padding: 10
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.05)',
                        borderDash: [5, 5]
                    },
                    ticks: { color: '#888' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#888' }
                }
            }
        }
    });
    const ctxGauge = document.getElementById('gaugeChart').getContext('2d');

    new Chart(ctxGauge, {
        type: 'doughnut',
        data: {
            labels: ['Pendapatan', 'Potensi'],
            datasets: [{
                data: [75, 25], 
                backgroundColor: [
                    '#6c5ce7',
                    '#2c2c2c'
                ],
                borderWidth: 0,
                circumference: 180, 
                rotation: 270, 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '85%',
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            }
        }
    });
</script>

@endsection