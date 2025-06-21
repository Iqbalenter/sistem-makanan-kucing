<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Perhitungan SMART</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding-top: 2rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        
        @media print {
            footer, .btn {
                display: none !important;
            }
            body {
                background: white !important;
                padding-top: 0 !important;
            }
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <!-- Content Area -->
            <div class="col-12 col-lg-10 col-xl-8 p-4">
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

                <!-- Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle" style="width: 80px; height: 80px;">
                                        <i class="fas fa-cat text-white" style="font-size: 2.5rem;"></i>
                                    </div>
                                </div>
                                <h2 class="mb-2">Detail Perhitungan SMART</h2>
                                <p class="text-muted mb-3">Analisis mendalam untuk: <strong class="text-primary">{{ $detail['alternative']->name }}</strong></p>
                                <span class="badge bg-primary fs-6">{{ $detail['alternative']->code }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($detail) && $detail['alternative'])
                    <!-- Alternative Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Informasi Produk
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Nama Produk:</td>
                                            <td>{{ $detail['alternative']->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Kode:</td>
                                            <td><span class="badge bg-secondary">{{ $detail['alternative']->code }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Protein:</td>
                                            <td><span class="text-success fw-bold">{{ $detail['alternative']->protein }}%</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Lemak:</td>
                                            <td><span class="text-warning fw-bold">{{ $detail['alternative']->fat }}%</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Serat:</td>
                                            <td><span class="text-info fw-bold">{{ $detail['alternative']->fiber }}%</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Kadar Air:</td>
                                            <td><span class="text-primary fw-bold">{{ $detail['alternative']->moisture }}%</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Harga:</td>
                                            <td><span class="badge bg-success fs-6">Rp {{ number_format($detail['alternative']->price, 0, ',', '.') }}</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-trophy me-2"></i>
                                        Hasil Perhitungan SMART
                                    </h5>
                                </div>
                                <div class="card-body text-center">
                                    @if(isset($detail['calculation']) && $detail['calculation'])
                                        <div class="mb-3">
                                            <h2 class="text-primary">{{ number_format($detail['calculation']->final_score, 4) }}</h2>
                                            <p class="text-muted">Skor Akhir</p>
                                        </div>
                                        <div class="mb-3">
                                            <h3 class="text-warning">Peringkat #{{ $detail['calculation']->rank }}</h3>
                                            <p class="text-muted">dari semua alternatif</p>
                                        </div>
                                        @if($detail['calculation']->rank <= 3)
                                            <div class="alert alert-success">
                                                <i class="fas fa-medal me-2"></i>
                                                <strong>Top 3 Rekomendasi!</strong>
                                            </div>
                                        @elseif($detail['calculation']->rank <= 5)
                                            <div class="alert alert-info">
                                                <i class="fas fa-thumbs-up me-2"></i>
                                                <strong>Direkomendasikan</strong>
                                            </div>
                                        @else
                                            <div class="alert alert-secondary">
                                                <i class="fas fa-star me-2"></i>
                                                <strong>Pilihan Alternatif</strong>
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Belum ada hasil perhitungan</strong><br>
                                            <small>Silakan jalankan perhitungan SMART terlebih dahulu</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Evaluations Data -->
                    @if(isset($detail['evaluations']) && $detail['evaluations']->count() > 0)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-chart-line me-2"></i>
                                        Detail Evaluasi per Kriteria
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Kriteria</th>
                                                    <th>Tipe</th>
                                                    <th>Nilai Mentah</th>
                                                    <th>Nilai Utilitas</th>
                                                    <th>Bobot</th>
                                                    <th>Nilai Berbobot</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($detail['evaluations'] as $evaluation)
                                                <tr>
                                                    <td class="fw-bold">{{ $evaluation->criteria->name }}</td>
                                                    <td>
                                                        <span class="badge {{ $evaluation->criteria->type === 'benefit' ? 'bg-success' : 'bg-warning' }}">
                                                            {{ $evaluation->criteria->type === 'benefit' ? 'Benefit' : 'Cost' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ number_format($evaluation->raw_value, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-info">{{ number_format($evaluation->utility_value, 4) }}</span>
                                                    </td>
                                                    <td>{{ $evaluation->criteria->weight }}%</td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ number_format($evaluation->weighted_value, 4) }}</span>
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
                @else
                    <div class="alert alert-warning">
                        <h4>No Data Found</h4>
                        <p>Detail data tidak tersedia atau alternatif tidak ditemukan.</p>
                    </div>
                @endif
                
                <!-- Navigation -->
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('smart.rankings') }}" class="btn btn-primary btn-lg me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Ranking
                            </a>
                            <a href="{{ route('smart.comparison') }}" class="btn btn-outline-info btn-lg me-md-2">
                                <i class="fas fa-chart-bar me-2"></i>Perbandingan
                            </a>
                            <button onclick="window.print()" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-print me-2"></i>Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-5">
        <div class="container">
            <p class="text-muted mb-0">
                © 2025 Sistem Pendukung Keputusan Pemilihan Makanan Kucing - 
                <strong>Metode SMART</strong>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 