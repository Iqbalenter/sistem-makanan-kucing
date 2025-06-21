<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbandingan Alternatif - User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('user.dashboard') }}">
                <i class="fas fa-cat me-2"></i>
                DSS Makanan Kucing
            </a>
            
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-2"></i>
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-bar text-info" style="font-size: 3rem;"></i>
                        <h1 class="mt-3 mb-2">📊 Perbandingan Alternatif</h1>
                        <p class="text-muted">Analisis dan perbandingan semua alternatif makanan kucing berdasarkan kriteria</p>
                    </div>
                </div>
            </div>
        </div>

        @php
            $totalAlternatives = \App\Models\Alternative::active()->count();
            $calculatedAlternatives = count($comparisonData);
            $hasNewAlternatives = $totalAlternatives > $calculatedAlternatives;
        @endphp

        @if($hasNewAlternatives)
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi:</strong> Ada {{ $totalAlternatives - $calculatedAlternatives }} alternatif baru yang belum masuk dalam perhitungan. 
                Silakan hubungi administrator untuk melakukan perhitungan ulang.
            </div>
        @endif

        @if(count($comparisonData) == 0)
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Belum ada data untuk dibandingkan. Silakan hubungi administrator untuk melakukan perhitungan SMART.
            </div>
        @elseif(!isset($chartData) || empty($chartData['alternatives']))
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                Data chart belum tersedia. Silakan hubungi administrator untuk melakukan perhitungan.
            </div>
        @else
            <!-- Charts Section -->
            <div class="row mb-4">
                <!-- Percentage Values Chart -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="mb-0">
                                <i class="fas fa-percentage me-2"></i>
                                Kandungan Nutrisi (%)
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="percentageChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Price Values Chart -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="mb-0">
                                <i class="fas fa-money-bill me-2"></i>
                                Perbandingan Harga (Rp)
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="priceChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Utility Values Chart -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="mb-0">
                                <i class="fas fa-line-chart me-2"></i>
                                Utility Values
                            </h5>
                        </div>
                        <div class="card-body">
                            <canvas id="utilityValuesChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Navigation -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Dashboard
                </a>
                <a href="{{ route('user.rankings') }}" class="btn btn-outline-success">
                    <i class="fas fa-trophy me-2"></i>
                    Lihat Ranking
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    @if(count($comparisonData) > 0 && isset($chartData) && !empty($chartData['alternatives']))
    // Prepare data for charts
    const alternatives = @json($chartData['alternatives']);
    const criteria = @json($chartData['criteria']);
    const rawData = @json($chartData['rawData']);
    const utilityData = @json($chartData['utilityData']);

    // Percentage Chart (C1-C4: Protein, Fat, Fiber, Moisture)
    const ctxPercentage = document.getElementById('percentageChart');
    if (ctxPercentage) {
        new Chart(ctxPercentage, {
            type: 'bar',
            data: {
                labels: alternatives,
                datasets: [
                    {
                        label: 'Protein (%)',
                        data: rawData.map(row => row[0]),
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Lemak (%)',
                        data: rawData.map(row => row[1]),
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Serat (%)',
                        data: rawData.map(row => row[2]),
                        backgroundColor: 'rgba(255, 206, 86, 0.8)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Air (%)',
                        data: rawData.map(row => row[3]),
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Price Chart (C5: Price)
    const ctxPrice = document.getElementById('priceChart');
    if (ctxPrice) {
        new Chart(ctxPrice, {
            type: 'bar',
            data: {
                labels: alternatives,
                datasets: [{
                    label: 'Harga (Rp)',
                    data: rawData.map(row => row[4]),
                    backgroundColor: 'rgba(153, 102, 255, 0.8)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Utility Values Chart
    const ctxUtility = document.getElementById('utilityValuesChart');
    if (ctxUtility) {
        new Chart(ctxUtility, {
            type: 'radar',
            data: {
                labels: criteria,
                datasets: alternatives.map((alt, index) => ({
                    label: alt,
                    data: utilityData[index],
                    borderColor: `hsl(${index * 360 / alternatives.length}, 70%, 50%)`,
                    backgroundColor: `hsla(${index * 360 / alternatives.length}, 70%, 50%, 0.2)`,
                    borderWidth: 2
                }))
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 1
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    @endif
    </script>
</body>
</html> 