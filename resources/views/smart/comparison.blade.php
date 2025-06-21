@extends('layouts.app')

@section('title', 'Perbandingan Alternatif - SPK Makanan Kucing')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-3">
            <i class="fas fa-chart-bar me-2"></i>
            Perbandingan Alternatif
        </h1>
        <p class="text-muted">Analisis dan perbandingan semua alternatif makanan kucing berdasarkan kriteria</p>
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
        <strong>Perhatian!</strong> Ada {{ $totalAlternatives - $calculatedAlternatives }} alternatif baru yang belum masuk dalam perhitungan. 
        <form action="{{ route('smart.calculate') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary ms-2">
                <i class="fas fa-calculator me-1"></i>
                Hitung Ulang SMART
            </button>
        </form>
    </div>
@endif

@if(count($comparisonData) == 0)
    <div class="alert alert-warning" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        Belum ada data untuk dibandingkan. Silakan lakukan perhitungan SMART terlebih dahulu.
        <a href="{{ route('smart.index') }}" class="alert-link">Kembali ke Dashboard</a>
    </div>
@elseif(!isset($chartData) || empty($chartData['alternatives']))
    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        Data chart belum tersedia. Pastikan perhitungan SMART sudah dilakukan dan ada data evaluasi.
        <form action="{{ route('smart.calculate') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-link alert-link p-0" style="text-decoration: underline;">
                Lakukan Perhitungan
            </button>
        </form>
    </div>
@else
    <!-- Charts Section -->
    <div class="row mb-4">
        <!-- Percentage Values Chart -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-percentage me-2"></i>
                        Perbandingan Kandungan (%)
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="percentageChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Price Values Chart -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-money-bill me-2"></i>
                        Perbandingan Harga (Rp)
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="priceChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Utility Values Chart -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-line-chart me-2"></i>
                        Perbandingan Utility Values
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="utilityValuesChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparison Table -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-table me-2"></i>
                        Tabel Perbandingan Lengkap
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th rowspan="2">Alternatif</th>
                                    <th colspan="{{ $criteria->count() }}" class="text-center">Nilai Raw</th>
                                    <th colspan="{{ $criteria->count() }}" class="text-center">Utility Values</th>
                                    <th colspan="{{ $criteria->count() }}" class="text-center">Weighted Values</th>
                                </tr>
                                <tr>
                                    @foreach($criteria as $criterion)
                                        <th class="text-center">{{ $criterion->code }}</th>
                                    @endforeach
                                    @foreach($criteria as $criterion)
                                        <th class="text-center">{{ $criterion->code }}</th>
                                    @endforeach
                                    @foreach($criteria as $criterion)
                                        <th class="text-center">{{ $criterion->code }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comparisonData as $data)
                                <tr>
                                    <td>
                                        <strong>{{ $data['alternative']->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $data['alternative']->code }}</small>
                                    </td>
                                    
                                    <!-- Raw Values -->
                                    @foreach($criteria as $criterion)
                                        <td class="text-center">
                                            @if(isset($data['evaluations'][$criterion->id]))
                                                {{ $data['evaluations'][$criterion->id]->raw_value }}
                                                @if($criterion->code != 'C5')%@endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
                                    
                                    <!-- Utility Values -->
                                    @foreach($criteria as $criterion)
                                        <td class="text-center">
                                            @if(isset($data['evaluations'][$criterion->id]))
                                                <span class="badge bg-info">
                                                    {{ number_format($data['evaluations'][$criterion->id]->utility_value, 4) }}
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
                                    
                                    <!-- Weighted Values -->
                                    @foreach($criteria as $criterion)
                                        <td class="text-center">
                                            @if(isset($data['evaluations'][$criterion->id]))
                                                <span class="badge bg-success">
                                                    {{ number_format($data['evaluations'][$criterion->id]->weighted_value, 4) }}
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Criteria Analysis -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        Analisis per Kriteria
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($criteria as $criterion)
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        {{ $criterion->name }}
                                        <span class="badge bg-{{ $criterion->type == 'benefit' ? 'success' : 'warning' }} ms-2">
                                            {{ ucfirst($criterion->type) }}
                                        </span>
                                    </h6>
                                    <p class="card-text">
                                        <small class="text-muted">{{ $criterion->description }}</small>
                                    </p>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <strong>Bobot</strong>
                                            <div class="text-primary">{{ $criterion->weight }}%</div>
                                        </div>
                                        <div class="col-6">
                                            <strong>Normalisasi</strong>
                                            <div class="text-primary">{{ $criterion->normalized_weight }}</div>
                                        </div>
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

    <!-- Alternative Analysis -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Ringkasan Alternatif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($comparisonData as $data)
                        <div class="col-md-3 mb-3">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ $data['alternative']->name }}</h6>
                                    <div class="mb-2">
                                        <span class="badge bg-primary">{{ $data['alternative']->code }}</span>
                                    </div>
                                    
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <small class="text-muted">Protein</small>
                                            <div><strong>{{ $data['alternative']->protein }}%</strong></div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Harga</small>
                                            <div><strong>{{ $data['alternative']->formatted_price }}</strong></div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <small class="text-muted">{{ $data['alternative']->brand }}</small>
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
@endif
@endsection

@push('scripts')
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
    const percentageCriteria = criteria.slice(0, 4); // First 4 criteria
    const percentageChart = new Chart(ctxPercentage.getContext('2d'), {
        type: 'bar',
        data: {
            labels: percentageCriteria,
            datasets: alternatives.map((alt, index) => ({
                label: alt,
                data: rawData[index].slice(0, 4), // First 4 values (percentage data)
                backgroundColor: `hsla(${index * 360 / alternatives.length}, 70%, 50%, 0.7)`,
                borderColor: `hsla(${index * 360 / alternatives.length}, 70%, 50%, 1)`,
                borderWidth: 1
            }))
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Kandungan Nutrisi (%)'
                },
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Persentase (%)'
                    }
                }
            }
        }
    });
}

// Price Chart (C5: Harga)
const ctxPrice = document.getElementById('priceChart');
if (ctxPrice) {
    const priceChart = new Chart(ctxPrice.getContext('2d'), {
        type: 'bar',
        data: {
            labels: alternatives,
            datasets: [{
                label: 'Harga',
                data: rawData.map(data => data[4]), // Fifth value (price data)
                backgroundColor: alternatives.map((alt, index) => 
                    `hsla(${index * 360 / alternatives.length}, 70%, 50%, 0.7)`
                ),
                borderColor: alternatives.map((alt, index) => 
                    `hsla(${index * 360 / alternatives.length}, 70%, 50%, 1)`
                ),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Perbandingan Harga'
                },
                legend: {
                    display: false // Hide legend since it's just one dataset
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Harga: Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                        }
                    }
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
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
}

// Utility Values Chart
const ctxUtility = document.getElementById('utilityValuesChart');
if (ctxUtility) {
    const chartUtility = new Chart(ctxUtility.getContext('2d'), {
    type: 'radar',
    data: {
        labels: criteria,
        datasets: alternatives.map((alt, index) => ({
            label: alt,
            data: utilityData[index],
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
                text: 'Perbandingan Utility Values (0-1)'
            },
            legend: {
                position: 'bottom'
            }
        },
        scales: {
            r: {
                beginAtZero: true,
                max: 1,
                title: {
                    display: true,
                    text: 'Utility Value'
                }
            }
        }
    }
    });
}
@endif
</script>
@endpush 