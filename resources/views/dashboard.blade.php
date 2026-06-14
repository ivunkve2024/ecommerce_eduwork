<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - My E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .stat-box {
            border-radius: 5px;
            transition: transform 0.2s;
        }
        .stat-box:hover {
            transform: translateY(-3px);
        }
        .icon-bg {
            font-size: 2.5rem;
            opacity: 0.3;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">My E-Commerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">Product Category</a>
                    </li>
                </ul>
                <div class="navbar-nav ms-auto align-items-center">
                    @auth
                        <span class="nav-link text-white me-3 mb-0">Halo, {{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <div class="mb-4">
            <h2 class="fw-bold text-dark mb-1">Dashboard</h2>           
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3 mb-4">
            
            <div class="col">
                <div class="card stat-box bg-primary text-white border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center p-3">
                        <div>
                            <p class="text-white-50 small mb-1 fw-bold text-uppercase">Product</p>
                            <h3 class="fw-bold mb-0">120</h3>
                        </div>
                        <div class="icon-bg">
                            <i class="fa-solid fa-box"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card stat-box bg-success text-white border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center p-3">
                        <div>
                            <p class="text-white-50 small mb-1 fw-bold text-uppercase">Category</p>
                            <h3 class="fw-bold mb-0">15</h3>
                        </div>
                        <div class="icon-bg">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card stat-box bg-warning text-dark border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center p-3">
                        <div>
                            <p class="text-dark-50 small mb-1 fw-bold text-uppercase">Order</p>
                            <h3 class="fw-bold mb-0">85</h3>
                        </div>
                        <div class="icon-bg">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card stat-box bg-danger text-white border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center p-3">
                        <div>
                            <p class="text-white-50 small mb-1 fw-bold text-uppercase">User</p>
                            <h3 class="fw-bold mb-0">2,450</h3>
                        </div>
                        <div class="icon-bg">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card stat-box bg-purple text-white border-0 shadow-sm h-100" style="background-color: #6f42c1 !important;">
                    <div class="card-body d-flex justify-content-between align-items-center p-3">
                        <div>
                            <p class="text-white-50 small mb-1 fw-bold text-uppercase">Clicks</p>
                            <h3 class="fw-bold mb-0">14.2K</h3>
                        </div>
                        <div class="icon-bg">
                            <i class="fa-solid fa-arrow-pointer"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Grafik Analisis Transaksi & Pendapatan Harian</h5>
                            <p class="text-muted small mb-0">Data statistik performa 7 hari terakhir</p>
                        </div>
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">Data Statis</span>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div style="position: relative; height:320px; width:100%">
                            <canvas id="transactionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Pesanan Terbaru (Recent Orders)</h5>
                            <p class="text-muted small mb-0">Daftar aktivitas transaksi terakhir pada toko Anda</p>
                        </div>
                        <button class="btn btn-sm btn-outline-primary fw-bold" type="button" style="font-size: 0.75rem;">Lihat Semua</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                                <thead class="table-dark text-uppercase tracking-wider" style="font-size: 0.75rem;">
                                    <tr>
                                        <th class="px-4 py-3" style="width: 15%">Order ID</th>
                                        <th class="px-4 py-3" style="width: 25%">Customer Name</th>
                                        <th class="px-4 py-3" style="width: 20%">Total Amount</th>
                                        <th class="px-4 py-3 text-center" style="width: 15%">Status</th>
                                        <th class="px-4 py-3 text-center" style="width: 25%">Order Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white text-dark">
                                    <tr>
                                        <td class="px-4 py-3 fw-bold text-muted">#TRX-98210</td>
                                        <td class="px-4 py-3 fw-bold text-dark">Ahmad Faisal</td>
                                        <td class="px-4 py-3 text-success fw-bold">Rp 450.000</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="badge bg-success px-2 py-1.5 rounded-pill" style="min-width: 80px;">Success</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-muted">14 Juni 2026 15:30</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 fw-bold text-muted">#TRX-98209</td>
                                        <td class="px-4 py-3 fw-bold text-dark">Siti Aminah</td>
                                        <td class="px-4 py-3 text-success fw-bold">Rp 1.250.000</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="badge bg-success px-2 py-1.5 rounded-pill" style="min-width: 80px;">Success</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-muted">14 Juni 2026 14:12</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 fw-bold text-muted">#TRX-98208</td>
                                        <td class="px-4 py-3 fw-bold text-dark">Budi Santoso</td>
                                        <td class="px-4 py-3 text-success fw-bold">Rp 185.000</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="badge bg-warning text-dark px-2 py-1.5 rounded-pill" style="min-width: 80px;">Pending</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-muted">14 Juni 2026 11:05</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 fw-bold text-muted">#TRX-98207</td>
                                        <td class="px-4 py-3 fw-bold text-dark">Rinaawati</td>
                                        <td class="px-4 py-3 text-success fw-bold">Rp 320.000</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="badge bg-success px-2 py-1.5 rounded-pill" style="min-width: 80px;">Success</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-muted">13 Juni 2026 21:45</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 fw-bold text-muted">#TRX-98206</td>
                                        <td class="px-4 py-3 fw-bold text-dark">Dedi Kurniawan</td>
                                        <td class="px-4 py-3 text-success fw-bold">Rp 75.000</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="badge bg-danger px-2 py-1.5 rounded-pill" style="min-width: 80px;">Cancelled</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-muted">13 Juni 2026 18:22</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Konfigurasi Chart.js Dua Sumbu
        const ctx = document.getElementById('transactionChart').getContext('2d');
        
        const transactionChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [
                    {
                        label: 'Total Transaksi (Sisi Kiri)',
                        data: [12, 19, 8, 15, 22, 30, 25],
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        yAxisID: 'yTrans',
                        order: 2
                    },
                    {
                        label: 'Total Revenue / Pendapatan (Sisi Kanan)',
                        data: [1800000, 2900000, 1100000, 2400000, 3800000, 5500000, 4200000],
                        type: 'line',
                        borderColor: '#ffc107',
                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                        tension: 0.3,
                        fill: true,
                        yAxisID: 'yRevenue',
                        order: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yTrans: {
                        type: 'linear',
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Jumlah Transaksi',
                            font: { weight: 'bold' }
                        },
                        ticks: {
                            callback: function(value) { return value + ' Trans'; }
                        }
                    },
                    yRevenue: {
                        type: 'linear',
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Pendapatan (IDR)',
                            font: { weight: 'bold' }
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.datasetIndex === 1) {
                                    label += 'Rp ' + context.raw.toLocaleString('id-ID');
                                } else {
                                    label += context.raw + ' Transaksi';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>