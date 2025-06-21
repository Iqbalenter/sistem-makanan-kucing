<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Sistem DSS Makanan Kucing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .feature-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
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
            <a class="navbar-brand" href="#">
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
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card feature-card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-cat" style="font-size: 4rem; opacity: 0.8;"></i>
                        <h1 class="mt-3 mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                        <p class="lead mb-0">Dashboard Sistem Pendukung Keputusan Pemilihan Makanan Kucing</p>
                        <p class="mb-0 mt-2">Lihat rekomendasi makanan terbaik untuk kucing kesayangan Anda</p>
                    </div>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Quick Stats -->
        @php
            $totalAlternatives = \App\Models\Alternative::active()->count();
            $totalCriteria = \App\Models\Criteria::active()->count();
            $hasCalculations = \App\Models\Calculation::count() > 0;
        @endphp

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-layer-group text-primary" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-3 mb-2">{{ $totalAlternatives }}</h3>
                        <p class="text-muted mb-0">Alternatif Makanan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-cogs text-success" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-3 mb-2">{{ $totalCriteria }}</h3>
                        <p class="text-muted mb-0">Kriteria Penilaian</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-{{ $hasCalculations ? 'check-circle text-success' : 'clock text-warning' }}" style="font-size: 2.5rem;"></i>
                        <h3 class="mt-3 mb-2">{{ $hasCalculations ? 'Tersedia' : 'Belum Ada' }}</h3>
                        <p class="text-muted mb-0">Hasil Perhitungan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Cards -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-trophy text-warning" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-3">Lihat Ranking</h5>
                        <p class="card-text">Lihat ranking dan rekomendasi makanan kucing terbaik berdasarkan perhitungan SMART</p>
                        @if($hasCalculations)
                            <a href="{{ route('user.rankings') }}" class="btn btn-primary">
                                <i class="fas fa-chart-line me-2"></i>
                                Lihat Ranking
                            </a>
                        @else
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Belum Ada Data
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-bar text-info" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-3">Perbandingan Alternatif</h5>
                        <p class="card-text">Bandingkan detail semua alternatif makanan kucing berdasarkan kriteria yang ada</p>
                        @if($hasCalculations)
                            <a href="{{ route('user.comparison') }}" class="btn btn-primary">
                                <i class="fas fa-balance-scale me-2"></i>
                                Lihat Perbandingan
                            </a>
                        @else
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Belum Ada Data
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Information Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Tentang Sistem
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-bullseye me-2 text-primary"></i>Tujuan Sistem</h6>
                                <p class="text-muted">
                                    Membantu Anda memilih makanan kucing terbaik berdasarkan kriteria nutrisi dan harga 
                                    menggunakan metode SMART (Simple Multi Attribute Rating Technique).
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-cogs me-2 text-success"></i>Kriteria Penilaian</h6>
                                <ul class="text-muted">
                                    <li>Kandungan Protein (35%)</li>
                                    <li>Kandungan Lemak (20%)</li>
                                    <li>Kandungan Serat (10%)</li>
                                    <li>Kadar Air (10%)</li>
                                    <li>Harga (25%)</li>
                                </ul>
                            </div>
                        </div>
                        
                        @if(!$hasCalculations)
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Informasi:</strong> Saat ini belum ada data perhitungan yang tersedia. 
                                Silakan hubungi administrator untuk melakukan perhitungan SMART.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 