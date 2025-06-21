@extends('layouts.app')

@section('title', 'Manajemen Alternatif - SPK Makanan Kucing')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-3">
            <i class="fas fa-list me-2"></i>
            Manajemen Alternatif
        </h1>
        <p class="text-muted">Data makanan kucing yang akan dibandingkan menggunakan metode SMART</p>
    </div>
</div>

<!-- Alternatives Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-database me-2"></i>
                    Data Alternatif Makanan Kucing
                </h5>
                <div>
                    <a href="{{ route('smart.alternatives.create') }}" class="btn btn-success btn-sm me-2">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Alternatif
                    </a>
                    <span class="badge bg-primary fs-6">{{ $alternatives->count() }} Alternatif</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="80">Kode</th>
                                <th>Nama Produk</th>
                                <th>Merek</th>
                                <th width="100">Protein (%)</th>
                                <th width="100">Lemak (%)</th>
                                <th width="100">Serat (%)</th>
                                <th width="100">K. Air (%)</th>
                                <th width="120">Harga</th>
                                <th width="100">Ukuran</th>
                                <th width="80">Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alternatives as $alternative)
                            <tr>
                                <td>
                                    <span class="badge bg-primary">{{ $alternative->code }}</span>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $alternative->name }}</strong>
                                        @if($alternative->description)
                                            <br>
                                            <small class="text-muted">{{ $alternative->description }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $alternative->brand }}</strong>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $alternative->protein }}%</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $alternative->fat }}%</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">{{ $alternative->fiber }}%</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $alternative->moisture }}%</span>
                                </td>
                                <td class="text-end">
                                    <strong>{{ $alternative->formatted_price }}</strong>
                                </td>
                                <td class="text-center">
                                    {{ $alternative->size }}
                                </td>
                                <td>
                                    @if($alternative->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('smart.alternatives.show', $alternative->id) }}" 
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('smart.alternatives.edit', $alternative->id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('smart.alternatives.destroy', $alternative->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus {{ $alternative->name }}?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
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

<!-- Statistics Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card border-0 bg-primary text-white">
            <div class="card-body text-center">
                <h4>{{ $alternatives->count() }}</h4>
                <p class="mb-0">Total Alternatif</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-success text-white">
            <div class="card-body text-center">
                <h4>{{ $alternatives->max('protein') }}%</h4>
                <p class="mb-0">Protein Tertinggi</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-warning text-white">
            <div class="card-body text-center">
                <h4>{{ 'Rp ' . number_format($alternatives->min('price'), 0, ',', '.') }}</h4>
                <p class="mb-0">Harga Terendah</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-info text-white">
            <div class="card-body text-center">
                <h4>{{ 'Rp ' . number_format($alternatives->max('price'), 0, ',', '.') }}</h4>
                <p class="mb-0">Harga Tertinggi</p>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Analysis -->
<div class="row mt-4">
    <!-- Protein Analysis -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Analisis Kandungan Protein
                </h5>
            </div>
            <div class="card-body">
                <canvas id="proteinChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Price Analysis -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-money-bill me-2"></i>
                    Analisis Harga
                </h5>
            </div>
            <div class="card-body">
                <canvas id="priceChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Nutritional Comparison -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-balance-scale me-2"></i>
                    Perbandingan Nutrisi
                </h5>
            </div>
            <div class="card-body">
                <canvas id="nutritionChart" height="400"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row mt-4">
    <div class="col-12 text-center">
        <a href="{{ route('smart.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali ke Dashboard
        </a>
        <a href="{{ route('smart.comparison') }}" class="btn btn-outline-info">
            <i class="fas fa-chart-bar me-2"></i>
            Lihat Perbandingan
        </a>
        <a href="{{ route('smart.criteria') }}" class="btn btn-outline-warning">
            <i class="fas fa-cogs me-2"></i>
            Kelola Kriteria
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Data for charts
const alternatives = @json($alternatives->pluck('name'));
const proteinData = @json($alternatives->pluck('protein'));
const fatData = @json($alternatives->pluck('fat'));
const fiberData = @json($alternatives->pluck('fiber'));
const moistureData = @json($alternatives->pluck('moisture'));
const priceData = @json($alternatives->pluck('price'));

// Protein Chart
const ctxProtein = document.getElementById('proteinChart').getContext('2d');
new Chart(ctxProtein, {
    type: 'bar',
    data: {
        labels: alternatives,
        datasets: [{
            label: 'Protein (%)',
            data: proteinData,
            backgroundColor: 'rgba(40, 167, 69, 0.8)',
            borderColor: 'rgba(40, 167, 69, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Kandungan Protein per Alternatif'
            },
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Persentase (%)'
                }
            },
            x: {
                ticks: {
                    maxRotation: 45
                }
            }
        }
    }
});

// Price Chart
const ctxPrice = document.getElementById('priceChart').getContext('2d');
new Chart(ctxPrice, {
    type: 'bar',
    data: {
        labels: alternatives,
        datasets: [{
            label: 'Harga (Rp)',
            data: priceData,
            backgroundColor: 'rgba(255, 193, 7, 0.8)',
            borderColor: 'rgba(255, 193, 7, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Harga per Alternatif'
            },
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Harga (Rp)'
                },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
            x: {
                ticks: {
                    maxRotation: 45
                }
            }
        }
    }
});

// Nutrition Chart (Radar)
const ctxNutrition = document.getElementById('nutritionChart').getContext('2d');
new Chart(ctxNutrition, {
    type: 'radar',
    data: {
        labels: ['Protein (%)', 'Lemak (%)', 'Serat (%)', 'Kadar Air (%)'],
        datasets: alternatives.map((alt, index) => ({
            label: alt,
            data: [proteinData[index], fatData[index], fiberData[index], moistureData[index]],
            borderColor: `hsla(${index * 360 / alternatives.length}, 70%, 50%, 1)`,
            backgroundColor: `hsla(${index * 360 / alternatives.length}, 70%, 50%, 0.2)`,
            pointBackgroundColor: `hsla(${index * 360 / alternatives.length}, 70%, 50%, 1)`,
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: `hsla(${index * 360 / alternatives.length}, 70%, 50%, 1)`
        }))
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Perbandingan Kandungan Nutrisi'
            },
            legend: {
                position: 'bottom'
            }
        },
        scales: {
            r: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Persentase (%)'
                }
            }
        }
    }
});
</script>
@endpush 