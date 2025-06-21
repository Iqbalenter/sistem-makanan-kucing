@extends('layouts.app')

@section('title', 'Dashboard - SPK Makanan Kucing')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-3">
            <i class="fas fa-tachometer-alt me-2"></i>
            Dashboard Sistem Pendukung Keputusan
        </h1>
        <p class="text-muted">Pemilihan Makanan Dry Food Kucing Kitten dengan Metode SMART</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="text-primary mb-1">{{ $alternatives->count() }}</h3>
                        <p class="text-muted mb-0">Alternatif</p>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-list fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="text-success mb-1">{{ $criteria->count() }}</h3>
                        <p class="text-muted mb-0">Kriteria</p>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-cogs fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="text-warning mb-1">{{ $hasCalculations ? 'Selesai' : 'Belum' }}</h3>
                        <p class="text-muted mb-0">Perhitungan</p>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-calculator fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="text-danger mb-1">{{ $rankings->count() }}</h3>
                        <p class="text-muted mb-0">Ranking</p>
                    </div>
                    <div class="text-danger">
                        <i class="fas fa-trophy fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Panel -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-play-circle me-2"></i>
                    Mulai Perhitungan SMART
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6>Metode Simple Multi Attribute Rating Technique (SMART)</h6>
                        <p class="text-muted mb-3">
                            Klik tombol di bawah untuk memulai perhitungan menggunakan metode SMART. 
                            Sistem akan menghitung nilai utility, bobot, dan ranking untuk semua alternatif makanan kucing.
                        </p>
                        
                        @if(!$hasCalculations)
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                Belum ada perhitungan yang dilakukan. Silakan klik "Hitung SMART" untuk memulai.
                            </div>
                        @else
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                Perhitungan SMART telah selesai. Anda dapat melihat hasilnya di menu Ranking.
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 text-center">
                        <form action="{{ route('smart.calculate') }}" method="POST" onsubmit="return confirm('Yakin ingin melakukan perhitungan SMART? Data perhitungan sebelumnya akan dihapus.')">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-calculator me-2"></i>
                                Hitung SMART
                            </button>
                        </form>
                        
                        @if($hasCalculations)
                            <div class="mt-3">
                                <a href="{{ route('smart.rankings') }}" class="btn btn-outline-success">
                                    <i class="fas fa-trophy me-2"></i>
                                    Lihat Ranking
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Results -->
@if($hasCalculations && $rankings->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-trophy me-2"></i>
                    Top 3 Rekomendasi
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($rankings->take(3) as $index => $ranking)
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    @if($index == 0)
                                        <span class="badge badge-rank rank-1">🥇 #1</span>
                                    @elseif($index == 1)
                                        <span class="badge badge-rank rank-2">🥈 #2</span>
                                    @else
                                        <span class="badge badge-rank rank-3">🥉 #3</span>
                                    @endif
                                </div>
                                <h5 class="card-title">{{ $ranking->alternative->name }}</h5>
                                <p class="text-muted">{{ $ranking->alternative->brand }}</p>
                                <h6 class="text-primary">Skor: {{ number_format($ranking->final_score, 4) }}</h6>
                                <small class="text-muted">{{ $ranking->alternative->formatted_price }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('smart.rankings') }}" class="btn btn-outline-primary">
                        Lihat Semua Ranking <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Data Overview -->
<div class="row">
    <!-- Kriteria -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Kriteria Penilaian
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kriteria</th>
                                <th>Tipe</th>
                                <th>Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($criteria as $criterion)
                            <tr>
                                <td>{{ $criterion->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $criterion->type == 'benefit' ? 'success' : 'warning' }}">
                                        {{ ucfirst($criterion->type) }}
                                    </span>
                                </td>
                                <td>{{ $criterion->weight }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('smart.criteria') }}" class="btn btn-outline-primary btn-sm">
                        Kelola Kriteria <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Alternatif -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Alternatif Makanan
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alternatives->take(5) as $alternative)
                            <tr>
                                <td><span class="badge bg-primary">{{ $alternative->code }}</span></td>
                                <td>{{ $alternative->name }}</td>
                                <td>{{ $alternative->formatted_price }}</td>
                            </tr>
                            @endforeach
                            @if($alternatives->count() > 5)
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    dan {{ $alternatives->count() - 5 }} lainnya...
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('smart.alternatives') }}" class="btn btn-outline-primary btn-sm">
                        Kelola Alternatif <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 