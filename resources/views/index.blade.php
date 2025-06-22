@extends('layouts.app')

@section('title', 'Sistem Pendukung Keputusan Makanan Kucing')

@section('content')
<!-- Hero Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="hero-section text-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 1rem;">
            <div class="container">
                <h1 class="display-4 text-white mb-3">
                    <i class="fas fa-cat me-3"></i>
                    Sistem Pendukung Keputusan
                </h1>
                <h2 class="h3 text-white-50 mb-4">Pemilihan Makanan Dry Food Kucing Kitten</h2>
                <p class="lead text-white mb-4">
                    Temukan makanan terbaik untuk kucing kesayangan Anda dengan teknologi SMART 
                    (Simple Multi Attribute Rating Technique)
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 py-2">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Masuk ke Sistem
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 py-2">
                            <i class="fas fa-user-plus me-2"></i>
                            Daftar Sekarang
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-4 py-2">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Ke Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="row mb-5">
    <div class="col-12 text-center mb-4">
        <h2 class="h3 mb-3">Mengapa Memilih Sistem Kami?</h2>
        <p class="text-muted">Dapatkan rekomendasi makanan kucing terbaik dengan analisis yang akurat</p>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-brain fa-3x text-primary"></i>
                </div>
                <h5 class="card-title">Metode SMART</h5>
                <p class="card-text text-muted">
                    Menggunakan algoritma Simple Multi Attribute Rating Technique untuk analisis yang akurat dan objektif.
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-chart-line fa-3x text-success"></i>
                </div>
                <h5 class="card-title">Analisis Komprehensif</h5>
                <p class="card-text text-muted">
                    Evaluasi berdasarkan kriteria nutrisi, harga, kualitas, dan faktor penting lainnya.
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-trophy fa-3x text-warning"></i>
                </div>
                <h5 class="card-title">Rekomendasi Terbaik</h5>
                <p class="card-text text-muted">
                    Dapatkan ranking makanan kucing terbaik berdasarkan kebutuhan dan preferensi Anda.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- How It Works Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header text-center">
                <h3 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Cara Kerja Sistem
                </h3>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="text-center">
                            <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <span class="h4 mb-0">1</span>
                            </div>
                            <h6>Input Kriteria</h6>
                            <p class="text-muted small">Sistem menganalisis berbagai kriteria penting untuk kucing kitten</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="text-center">
                            <div class="step-number bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <span class="h4 mb-0">2</span>
                            </div>
                            <h6>Evaluasi Alternatif</h6>
                            <p class="text-muted small">Penilaian semua produk makanan berdasarkan kriteria yang ada</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="text-center">
                            <div class="step-number bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <span class="h4 mb-0">3</span>
                            </div>
                            <h6>Perhitungan SMART</h6>
                            <p class="text-muted small">Algoritma SMART menghitung skor untuk setiap alternatif</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="text-center">
                            <div class="step-number bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <span class="h4 mb-0">4</span>
                            </div>
                            <h6>Rekomendasi</h6>
                            <p class="text-muted small">Dapatkan ranking makanan terbaik untuk kucing Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section (if available) -->
<div class="row mb-5">
    <div class="col-12">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card border-0 bg-primary text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-list fa-2x mb-3"></i>
                        <h3 class="mb-1">10+</h3>
                        <p class="mb-0">Produk Makanan</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-0 bg-success text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-cogs fa-2x mb-3"></i>
                        <h3 class="mb-1">5+</h3>
                        <p class="mb-0">Kriteria Evaluasi</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-0 bg-warning text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-users fa-2x mb-3"></i>
                        <h3 class="mb-1">100+</h3>
                        <p class="mb-0">Pengguna Aktif</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-0 bg-info text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-star fa-2x mb-3"></i>
                        <h3 class="mb-1">95%</h3>
                        <p class="mb-0">Akurasi Sistem</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-5">
                <h3 class="mb-3">Siap Menemukan Makanan Terbaik untuk Kucing Anda?</h3>
                <p class="text-muted mb-4">
                    Bergabunglah dengan ribuan pemilik kucing yang telah merasakan manfaat sistem kami.
                </p>
                @guest
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>
                            Daftar Gratis Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Sudah Punya Akun?
                        </a>
                    </div>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Mulai Analisis Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hero-section {
        background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" patternUnits="userSpaceOnUse" width="100" height="100"><circle cx="50" cy="50" r="0.5" fill="white" opacity="0.1"/><circle cx="20" cy="20" r="0.3" fill="white" opacity="0.05"/><circle cx="80" cy="30" r="0.4" fill="white" opacity="0.08"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    }
    
    .feature-icon {
        transition: transform 0.3s ease;
    }
    
    .card:hover .feature-icon {
        transform: translateY(-5px);
    }
    
    .step-number {
        font-weight: bold;
        transition: transform 0.3s ease;
    }
    
    .step-number:hover {
        transform: scale(1.1);
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add smooth scrolling animation
    document.addEventListener('DOMContentLoaded', function() {
        // Animate cards on scroll
        const cards = document.querySelectorAll('.card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });
        
        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    });
</script>
@endpush
