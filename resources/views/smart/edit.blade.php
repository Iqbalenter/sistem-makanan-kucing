@extends('layouts.app')

@section('title', 'Edit ' . $alternative->name . ' - SPK Makanan Kucing')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-3">
            <i class="fas fa-edit me-2"></i>
            Edit Alternatif: {{ $alternative->name }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('smart.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('smart.alternatives') }}">Manajemen Alternatif</a></li>
                <li class="breadcrumb-item"><a href="{{ route('smart.alternatives.show', $alternative->id) }}">{{ $alternative->name }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
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
                    Form Edit Alternatif
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('smart.alternatives.update', $alternative->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="code" class="form-label">Kode Alternatif</label>
                            <input type="text" class="form-control" value="{{ $alternative->code }}" readonly>
                            <small class="text-muted">Kode tidak dapat diubah</small>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select name="is_active" id="is_active" class="form-select">
                                <option value="1" {{ $alternative->is_active ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$alternative->is_active ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="{{ $alternative->name }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Merek <span class="text-danger">*</span></label>
                            <input type="text" name="brand" id="brand" class="form-control" 
                                   value="{{ $alternative->brand }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Produk</label>
                        <textarea name="description" id="description" rows="3" class="form-control" 
                                  placeholder="Deskripsi singkat tentang produk makanan kucing">{{ $alternative->description }}</textarea>
                    </div>

                    <h6 class="mb-3 text-primary">
                        <i class="fas fa-leaf me-2"></i>
                        Kandungan Nutrisi
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="protein" class="form-label">Protein (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="protein" id="protein" class="form-control" 
                                       value="{{ $alternative->protein }}" 
                                       min="0" max="100" step="0.01" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="fat" class="form-label">Lemak (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="fat" id="fat" class="form-control" 
                                       value="{{ $alternative->fat }}" 
                                       min="0" max="100" step="0.01" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="fiber" class="form-label">Serat (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="fiber" id="fiber" class="form-control" 
                                       value="{{ $alternative->fiber }}" 
                                       min="0" max="100" step="0.01" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="moisture" class="form-label">Kadar Air (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="moisture" id="moisture" class="form-control" 
                                       value="{{ $alternative->moisture }}" 
                                       min="0" max="100" step="0.01" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <h6 class="mb-3 text-primary">
                        <i class="fas fa-tag me-2"></i>
                        Informasi Harga & Ukuran
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" id="price" class="form-control" 
                                       value="{{ $alternative->price }}" min="0" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="size" class="form-label">Ukuran Kemasan <span class="text-danger">*</span></label>
                            <input type="text" name="size" id="size" class="form-control" 
                                   value="{{ $alternative->size }}" 
                                   placeholder="contoh: 1 kg, 1.2 kg, 500g" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>
                            Update Alternatif
                        </button>
                        <a href="{{ route('smart.alternatives.show', $alternative->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Data Saat Ini
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Kode:</strong></td>
                        <td><span class="badge bg-primary">{{ $alternative->code }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Protein:</strong></td>
                        <td><span class="badge bg-success">{{ $alternative->protein }}%</span></td>
                    </tr>
                    <tr>
                        <td><strong>Lemak:</strong></td>
                        <td><span class="badge bg-info">{{ $alternative->fat }}%</span></td>
                    </tr>
                    <tr>
                        <td><strong>Serat:</strong></td>
                        <td><span class="badge bg-warning">{{ $alternative->fiber }}%</span></td>
                    </tr>
                    <tr>
                        <td><strong>Kadar Air:</strong></td>
                        <td><span class="badge bg-secondary">{{ $alternative->moisture }}%</span></td>
                    </tr>
                    <tr>
                        <td><strong>Harga:</strong></td>
                        <td><strong class="text-success">{{ $alternative->formatted_price }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Peringatan
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <small>
                        <strong>Perhatian:</strong> Mengubah data alternatif akan mempengaruhi hasil perhitungan SMART. 
                        Lakukan perhitungan ulang setelah mengupdate data.
                    </small>
                </div>
                
                <div class="alert alert-info">
                    <small>
                        <strong>Tips:</strong> Pastikan data nutrisi sesuai dengan label kemasan yang akurat.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 