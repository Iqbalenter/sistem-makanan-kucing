<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking Makanan Kucing - User Dashboard</title>
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
        .badge-rank {
            font-size: 1.2em;
            padding: 0.5em;
        }
        .rank-1 { background-color: #ffd700; color: #333; }
        .rank-2 { background-color: #c0c0c0; color: #333; }
        .rank-3 { background-color: #cd7f32; color: white; }
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
                        <i class="fas fa-trophy text-warning" style="font-size: 3rem;"></i>
                        <h1 class="mt-3 mb-2">🏆 Ranking Makanan Kucing Terbaik</h1>
                        <p class="text-muted">Hasil perhitungan menggunakan metode SMART (Simple Multi Attribute Rating Technique)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(count($rankings) == 0)
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                Belum ada data ranking yang tersedia. Silakan hubungi administrator untuk melakukan perhitungan.
            </div>
        @else
            <!-- Top 3 Podium -->
            @if(count($rankings) >= 3)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="mb-0">
                                <i class="fas fa-medal me-2"></i>
                                Top 3 Rekomendasi Terbaik
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <!-- Rank 2 -->
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-light h-100">
                                        <div class="card-body">
                                            <span class="badge rank-2 badge-rank mb-3">#2</span>
                                            <h5>{{ $rankings[1]->alternative->name }}</h5>
                                            <p class="text-muted">{{ $rankings[1]->alternative->brand }}</p>
                                            <h4 class="text-primary">{{ number_format($rankings[1]->final_score, 4) }}</h4>
                                            <small class="text-muted">Skor Akhir</small>
                                            <div class="mt-2">
                                                <span class="badge bg-primary">{{ $rankings[1]->alternative->formatted_price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Rank 1 -->
                                <div class="col-md-4 mb-3">
                                    <div class="card border-warning bg-light h-100">
                                        <div class="card-body">
                                            <span class="badge rank-1 badge-rank mb-3">#1</span>
                                            <h5><strong>{{ $rankings[0]->alternative->name }}</strong></h5>
                                            <p class="text-muted">{{ $rankings[0]->alternative->brand }}</p>
                                            <h3 class="text-warning"><strong>{{ number_format($rankings[0]->final_score, 4) }}</strong></h3>
                                            <small class="text-muted">Skor Akhir</small>
                                            <div class="mt-2">
                                                <span class="badge bg-warning text-dark">🏆 TERBAIK</span>
                                            </div>
                                            <div class="mt-1">
                                                <span class="badge bg-primary">{{ $rankings[0]->alternative->formatted_price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Rank 3 -->
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-light h-100">
                                        <div class="card-body">
                                            <span class="badge rank-3 badge-rank mb-3">#3</span>
                                            <h5>{{ $rankings[2]->alternative->name }}</h5>
                                            <p class="text-muted">{{ $rankings[2]->alternative->brand }}</p>
                                            <h4 class="text-primary">{{ number_format($rankings[2]->final_score, 4) }}</h4>
                                            <small class="text-muted">Skor Akhir</small>
                                            <div class="mt-2">
                                                <span class="badge bg-primary">{{ $rankings[2]->alternative->formatted_price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Complete Rankings Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>
                                Ranking Lengkap Semua Alternatif
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Rank</th>
                                            <th>Kode</th>
                                            <th>Nama Produk</th>
                                            <th class="text-center">Protein</th>
                                            <th class="text-center">Lemak</th>
                                            <th class="text-center">Serat</th>
                                            <th class="text-center">Air</th>
                                            <th class="text-end">Harga</th>
                                            <th class="text-center">Skor Akhir</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rankings as $ranking)
                                        <tr>
                                            <td>
                                                @if($ranking->rank <= 3)
                                                    <span class="badge rank-{{ $ranking->rank }} badge-rank">
                                                        #{{ $ranking->rank }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">#{{ $ranking->rank }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $ranking->alternative->code }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $ranking->alternative->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $ranking->alternative->brand }}</small>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $ranking->alternative->protein }}%</td>
                                            <td class="text-center">{{ $ranking->alternative->fat }}%</td>
                                            <td class="text-center">{{ $ranking->alternative->fiber }}%</td>
                                            <td class="text-center">{{ $ranking->alternative->moisture }}%</td>
                                            <td class="text-end">{{ $ranking->alternative->formatted_price }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-success">
                                                    {{ number_format($ranking->final_score, 4) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('user.detail', $ranking->alternative->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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