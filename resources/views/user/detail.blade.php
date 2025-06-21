<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail {{ $detail['alternative']->name }} - User Dashboard</title>
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
                        <i class="fas fa-info-circle text-primary" style="font-size: 3rem;"></i>
                        <h1 class="mt-3 mb-2">Detail {{ $detail['alternative']->name }}</h1>
                        <p class="text-muted">Informasi lengkap dan hasil perhitungan SMART</p>
                        <span class="badge bg-primary fs-6">{{ $detail['alternative']->code }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alternative Info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-tag me-2"></i>
                            Informasi Produk
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nama Produk:</strong></td>
                                <td>{{ $detail['alternative']->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Merek:</strong></td>
                                <td>{{ $detail['alternative']->brand }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ukuran:</strong></td>
                                <td>{{ $detail['alternative']->size }}</td>
                            </tr>
                            <tr>
                                <td><strong>Harga:</strong></td>
                                <td><span class="badge bg-success">{{ $detail['alternative']->formatted_price }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Deskripsi:</strong></td>
                                <td>{{ $detail['alternative']->description ?: 'Tidak ada deskripsi' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-award me-2"></i>
                            Hasil SMART
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <h2 class="text-primary">{{ number_format($detail['final_score'], 6) }}</h2>
                            <p class="text-muted">Skor Akhir</p>
                        </div>
                        <div class="mb-3">
                            <h3 class="text-warning">Peringkat #{{ $detail['rank'] }}</h3>
                            <p class="text-muted">dari semua alternatif</p>
                        </div>
                        @if($detail['rank'] <= 3)
                            <div class="alert alert-success">
                                <i class="fas fa-trophy me-2"></i>
                                <strong>Top 3 Rekomendasi!</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="row">
            <div class="col-12 text-center">
                <a href="{{ route('user.rankings') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Rankings
                </a>
                <a href="{{ route('user.comparison') }}" class="btn btn-outline-info">
                    <i class="fas fa-chart-bar me-2"></i>
                    Lihat Perbandingan
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 