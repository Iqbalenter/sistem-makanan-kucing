@extends('layouts.app')

@section('title', 'Tambah Alternatif - SPK Makanan Kucing')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-3">
            <i class="fas fa-plus me-2"></i>
            Tambah Alternatif Makanan Kucing
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('smart.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('smart.alternatives') }}">Manajemen Alternatif</a></li>
                <li class="breadcrumb-item active">Tambah Alternatif</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-form me-2"></i>
                    Form Tambah Alternatif
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('smart.alternatives.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Kode Alternatif -->
                        <div class="col-md-4 mb-3">
                            <label for="code" class="form-label">Kode Alternatif</label>
                            <input type="text" class="form-control" value="{{ $nextCode }}" readonly>
                            <small class="text-muted">Kode akan dibuat otomatis</small>
                        </div>
                        
                        <!-- Status -->
                        <div class="col-md-4 mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select name="is_active" id="is_active" class="form-select @error('is_active') is-invalid @enderror">
                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Nama Produk -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Merek -->
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Merek <span class="text-danger">*</span></label>
                            <input type="text" name="brand" id="brand" 
                                   class="form-control @error('brand') is-invalid @enderror" 
                                   value="{{ old('brand') }}" required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Produk</label>
                        <textarea name="description" id="description" rows="3" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="Deskripsi singkat tentang produk makanan kucing">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kandungan Nutrisi -->
                    <h6 class="mb-3 text-primary">
                        <i class="fas fa-leaf me-2"></i>
                        Kandungan Nutrisi
                    </h6>
                    
                    <div class="row">
                        <!-- Protein -->
                        <div class="col-md-3 mb-3">
                            <label for="protein" class="form-label">Protein (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="protein" id="protein" 
                                       class="form-control @error('protein') is-invalid @enderror" 
                                       value="{{ old('protein') }}" 
                                       min="0" max="100" step="0.01" required>
                                <span class="input-group-text">%</span>
                            </div>
                            @error('protein')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Lemak -->
                        <div class="col-md-3 mb-3">
                            <label for="fat" class="form-label">Lemak (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="fat" id="fat" 
                                       class="form-control @error('fat') is-invalid @enderror" 
                                       value="{{ old('fat') }}" 
                                       min="0" max="100" step="0.01" required>
                                <span class="input-group-text">%</span>
                            </div>
                            @error('fat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Serat -->
                        <div class="col-md-3 mb-3">
                            <label for="fiber" class="form-label">Serat (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="fiber" id="fiber" 
                                       class="form-control @error('fiber') is-invalid @enderror" 
                                       value="{{ old('fiber') }}" 
                                       min="0" max="100" step="0.01" required>
                                <span class="input-group-text">%</span>
                            </div>
                            @error('fiber')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Kadar Air -->
                        <div class="col-md-3 mb-3">
                            <label for="moisture" class="form-label">Kadar Air (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="moisture" id="moisture" 
                                       class="form-control @error('moisture') is-invalid @enderror" 
                                       value="{{ old('moisture') }}" 
                                       min="0" max="100" step="0.01" required>
                                <span class="input-group-text">%</span>
                            </div>
                            @error('moisture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Harga dan Ukuran -->
                    <h6 class="mb-3 text-primary">
                        <i class="fas fa-tag me-2"></i>
                        Informasi Harga & Ukuran
                    </h6>
                    
                    <div class="row">
                        <!-- Harga -->
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" id="price" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price') }}" 
                                       min="0" required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Ukuran -->
                        <div class="col-md-6 mb-3">
                            <label for="size" class="form-label">Ukuran Kemasan <span class="text-danger">*</span></label>
                            <input type="text" name="size" id="size" 
                                   class="form-control @error('size') is-invalid @enderror" 
                                   value="{{ old('size') }}" 
                                   placeholder="contoh: 1 kg, 1.2 kg, 500g" required>
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>
                            Simpan Alternatif
                        </button>
                        <a href="{{ route('smart.alternatives') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Info -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Panduan Pengisian
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">Kandungan Nutrisi</h6>
                    <small class="text-muted">
                        Masukkan nilai persentase kandungan nutrisi sesuai label kemasan produk:
                        <ul class="mt-2">
                            <li><strong>Protein:</strong> Biasanya 25-40%</li>
                            <li><strong>Lemak:</strong> Biasanya 8-20%</li>
                            <li><strong>Serat:</strong> Biasanya 2-6%</li>
                            <li><strong>Kadar Air:</strong> Maksimal 12%</li>
                        </ul>
                    </small>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-primary">Harga</h6>
                    <small class="text-muted">
                        Masukkan harga dalam Rupiah tanpa titik atau koma.
                        Contoh: 25000 untuk Rp 25.000
                    </small>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Tips:</strong> Pastikan data yang dimasukkan akurat untuk hasil analisis SMART yang optimal.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Format price input
document.getElementById('price').addEventListener('input', function(e) {
    // Remove non-numeric characters
    let value = e.target.value.replace(/\D/g, '');
    e.target.value = value;
});

// Auto-capitalize first letter of name and brand
document.getElementById('name').addEventListener('input', function(e) {
    e.target.value = e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
});

document.getElementById('brand').addEventListener('input', function(e) {
    e.target.value = e.target.value.charAt(0).toUpperCase() + e.target.value.slice(1);
});
</script>
@endpush 