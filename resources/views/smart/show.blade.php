@extends('layouts.app')

@section('title', 'Detail ' . $alternative->name . ' - SPK Makanan Kucing')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-3">
            <i class="fas fa-eye me-2"></i>
            Detail Alternatif: {{ $alternative->name }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('smart.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('smart.alternatives') }}">Manajemen Alternatif</a></li>
                <li class="breadcrumb-item active">{{ $alternative->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <!-- Main Information -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Produk
                </h5>
                <div>
                    @if($alternative->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Tidak Aktif</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="120"><strong>Kode:</strong></td>
                                <td><span class="badge bg-primary">{{ $alternative->code }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>Nama:</strong></td>
                                <td>{{ $alternative->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Merek:</strong></td>
                                <td>{{ $alternative->brand }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ukuran:</strong></td>
                                <td>{{ $alternative->size }}</td>
                            </tr>
                            <tr>
                                <td><strong>Harga:</strong></td>
                                <td><strong class="text-success">{{ $alternative->formatted_price }}</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        @if($alternative->description)
                        <h6 class="text-primary">Deskripsi Produk</h6>
                        <p class="text-muted">{{ $alternative->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Nutritional Information -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-leaf me-2"></i>
                    Kandungan Nutrisi
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <div class="p-3 bg-success bg-opacity-10 rounded">
                            <i class="fas fa-drumstick-bite text-success fs-1"></i>
                            <h4 class="mt-2 text-success">{{ $alternative->protein }}%</h4>
                            <p class="mb-0">Protein</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-3 bg-info bg-opacity-10 rounded">
                            <i class="fas fa-oil-can text-info fs-1"></i>
                            <h4 class="mt-2 text-info">{{ $alternative->fat }}%</h4>
                            <p class="mb-0">Lemak</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-3 bg-warning bg-opacity-10 rounded">
                            <i class="fas fa-seedling text-warning fs-1"></i>
                            <h4 class="mt-2 text-warning">{{ $alternative->fiber }}%</h4>
                            <p class="mb-0">Serat</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-3 bg-secondary bg-opacity-10 rounded">
                            <i class="fas fa-tint text-secondary fs-1"></i>
                            <h4 class="mt-2 text-secondary">{{ $alternative->moisture }}%</h4>
                            <p class="mb-0">Kadar Air</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SMART Calculation Results -->
        @if($latestCalculation)
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calculator me-2"></i>
                    Hasil Perhitungan SMART Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6">
                        <div class="p-4 bg-primary bg-opacity-10 rounded">
                            <h2 class="text-primary">{{ number_format($latestCalculation->final_score, 6) }}</h2>
                            <p class="mb-0">Skor Akhir</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-warning bg-opacity-10 rounded">
                            <h2 class="text-warning">{{ $latestCalculation->rank }}</h2>
                            <p class="mb-0">Peringkat</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        Perhitungan terakhir: {{ $latestCalculation->calculated_at->format('d M Y, H:i') }}
                    </small>
                </div>
            </div>
        </div>
        @else
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle text-warning fs-1 mb-3"></i>
                <h5>Belum Ada Perhitungan SMART</h5>
                <p class="text-muted">Lakukan perhitungan SMART untuk melihat skor dan peringkat alternatif ini.</p>
                <a href="{{ route('smart.index') }}" class="btn btn-primary">
                    <i class="fas fa-calculator me-2"></i>
                    Lakukan Perhitungan
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar Actions -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Aksi
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('smart.alternatives.edit', $alternative->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit Alternatif
                    </a>
                    <a href="{{ route('smart.alternatives') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Daftar
                    </a>
                    <form action="{{ route('smart.alternatives.destroy', $alternative->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('Yakin ingin menghapus {{ $alternative->name }}?')">
                            <i class="fas fa-trash me-2"></i>
                            Hapus Alternatif
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistik Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Harga per 100g:</small>
                    <br>
                    @php
                        $weightInGrams = 1000; // Default 1kg
                        if (strpos($alternative->size, 'kg') !== false) {
                            $weightInGrams = floatval($alternative->size) * 1000;
                        } elseif (strpos($alternative->size, 'g') !== false) {
                            $weightInGrams = floatval($alternative->size);
                        }
                        $pricePerGram = $alternative->price / $weightInGrams;
                        $pricePer100g = $pricePerGram * 100;
                    @endphp
                    <strong>Rp {{ number_format($pricePer100g, 0) }}</strong>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Total Nutrisi:</small>
                    <br>
                    <strong>{{ $alternative->protein + $alternative->fat + $alternative->fiber + $alternative->moisture }}%</strong>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Rasio Protein/Harga:</small>
                    <br>
                    <strong>{{ number_format($alternative->protein / ($alternative->price / 1000), 4) }}</strong>
                    <small class="text-muted">(%/Rp1000)</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 