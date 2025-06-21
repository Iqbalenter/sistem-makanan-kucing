@extends('layouts.app')

@section('title', 'Ranking - SPK Makanan Kucing')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-3">
            <i class="fas fa-trophy me-2"></i>
            Hasil Ranking SMART
        </h1>
        <p class="text-muted">Ranking makanan kucing berdasarkan metode Simple Multi Attribute Rating Technique</p>
    </div>
</div>

@if($rankings->count() == 0)
    <div class="alert alert-warning" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        Belum ada hasil perhitungan. Silakan lakukan perhitungan SMART terlebih dahulu di dashboard.
        <a href="{{ route('smart.index') }}" class="alert-link">Kembali ke Dashboard</a>
    </div>
@else
    <!-- Top 3 Winners -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-medal me-2"></i>
                        Top 3 Makanan Kucing Terbaik
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($rankings->take(3) as $index => $ranking)
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        @if($index == 0)
                                            <div class="mb-2">🏆</div>
                                            <span class="badge badge-rank rank-1 fs-5">#1</span>
                                        @elseif($index == 1)
                                            <div class="mb-2">🥈</div>
                                            <span class="badge badge-rank rank-2 fs-5">#2</span>
                                        @else
                                            <div class="mb-2">🥉</div>
                                            <span class="badge badge-rank rank-3 fs-5">#3</span>
                                        @endif
                                    </div>
                                    
                                    <h4 class="card-title">{{ $ranking->alternative->name }}</h4>
                                    <p class="text-muted">{{ $ranking->alternative->brand }}</p>
                                    
                                    <div class="bg-light p-3 rounded mb-3">
                                        <h5 class="text-primary mb-0">
                                            Skor: {{ number_format($ranking->final_score, 4) }}
                                        </h5>
                                    </div>
                                    
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <small class="text-muted">Protein</small>
                                            <div class="fw-bold">{{ $ranking->alternative->protein }}%</div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Harga</small>
                                            <div class="fw-bold">{{ $ranking->alternative->formatted_price }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <a href="{{ route('smart.detail', $ranking->alternative->id) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Complete Ranking Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list-ol me-2"></i>
                        Ranking Lengkap
                    </h5>
                    <div>
                        <a href="{{ route('smart.comparison') }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-chart-bar me-1"></i>
                            Perbandingan
                        </a>
                        <a href="{{ route('smart.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-calculator me-1"></i>
                            Hitung Ulang
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="80">Rank</th>
                                    <th width="80">Kode</th>
                                    <th>Nama Produk</th>
                                    <th width="100">Protein</th>
                                    <th width="100">Lemak</th>
                                    <th width="100">Serat</th>
                                    <th width="100">K. Air</th>
                                    <th width="120">Harga</th>
                                    <th width="120">Skor Akhir</th>
                                    <th width="100">Aksi</th>
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
                                        <span class="badge bg-success fs-6">
                                            {{ number_format($ranking->final_score, 4) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('smart.detail', $ranking->alternative->id) }}" 
                                           class="btn btn-outline-primary btn-sm">
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

    <!-- Summary Statistics -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card border-0 bg-primary text-white">
                <div class="card-body text-center">
                    <h3>{{ $rankings->count() }}</h3>
                    <p class="mb-0">Total Alternatif</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-success text-white">
                <div class="card-body text-center">
                    <h3>{{ number_format($rankings->max('final_score'), 4) }}</h3>
                    <p class="mb-0">Skor Tertinggi</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-warning text-white">
                <div class="card-body text-center">
                    <h3>{{ number_format($rankings->min('final_score'), 4) }}</h3>
                    <p class="mb-0">Skor Terendah</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-info text-white">
                <div class="card-body text-center">
                    <h3>{{ number_format($rankings->avg('final_score'), 4) }}</h3>
                    <p class="mb-0">Rata-rata Skor</p>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    // Auto refresh setiap 5 menit jika tidak ada ranking
    @if($rankings->count() == 0)
        setTimeout(function() {
            location.reload();
        }, 300000);
    @endif
</script>
@endpush 