@extends('layouts.app')

@section('title', 'Manajemen Kriteria - SPK Makanan Kucing')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-3">
            <i class="fas fa-cogs me-2"></i>
            Manajemen Kriteria
        </h1>
        <p class="text-muted">Kelola kriteria penilaian dan bobot untuk perhitungan SMART</p>
    </div>
</div>

<!-- Criteria Weight Management -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-balance-scale me-2"></i>
                    Pengaturan Bobot Kriteria
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('smart.criteria.weights.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Catatan:</strong> Total bobot harus berjumlah 100%. Sistem akan menolak jika total tidak sama dengan 100%.
                    </div>
                    
                    <div class="row">
                        @foreach($criteria as $criterion)
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h6 class="card-title mb-1">
                                                {{ $criterion->name }}
                                                <span class="badge bg-{{ $criterion->type == 'benefit' ? 'success' : 'warning' }} ms-2">
                                                    {{ ucfirst($criterion->type) }}
                                                </span>
                                            </h6>
                                            <p class="card-text small text-muted mb-2">
                                                {{ $criterion->description }}
                                            </p>
                                            <small class="text-muted">Kode: {{ $criterion->code }}</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="input-group">
                                                <input type="number" 
                                                       class="form-control text-center fw-bold @error('weights.'.$criterion->id) is-invalid @enderror" 
                                                       name="weights[{{ $criterion->id }}]" 
                                                       value="{{ old('weights.'.$criterion->id, $criterion->weight) }}"
                                                       min="0" 
                                                       max="100" 
                                                       required>
                                                <span class="input-group-text">%</span>
                                            </div>
                                            @error('weights.'.$criterion->id)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Total Weight Display -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <h5 class="card-title">
                                        Total Bobot: <span id="totalWeight" class="text-primary">{{ $criteria->sum('weight') }}%</span>
                                    </h5>
                                    <div id="weightStatus" class="mt-2">
                                        @if($criteria->sum('weight') == 100)
                                            <span class="badge bg-success fs-6">✓ Total sudah benar (100%)</span>
                                        @else
                                            <span class="badge bg-danger fs-6">✗ Total harus 100%</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save me-2"></i>
                            Simpan Perubahan Bobot
                        </button>
                        <a href="{{ route('smart.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Criteria Information -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Kriteria
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Nama Kriteria</th>
                                <th>Deskripsi</th>
                                <th>Tipe</th>
                                <th>Bobot</th>
                                <th>Normalisasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($criteria as $criterion)
                            <tr>
                                <td>
                                    <span class="badge bg-primary">{{ $criterion->code }}</span>
                                </td>
                                <td>
                                    <strong>{{ $criterion->name }}</strong>
                                </td>
                                <td>
                                    <small>{{ $criterion->description }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $criterion->type == 'benefit' ? 'success' : 'warning' }}">
                                        {{ ucfirst($criterion->type) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <strong>{{ $criterion->weight }}%</strong>
                                </td>
                                <td class="text-center">
                                    {{ $criterion->normalized_weight }}
                                </td>
                                <td>
                                    @if($criterion->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
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
@endsection

@push('scripts')
<script>
// Calculate total weight in real-time
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('input[name^="weights"]').forEach(input => {
        total += parseInt(input.value) || 0;
    });
    
    const totalWeightSpan = document.getElementById('totalWeight');
    const weightStatus = document.getElementById('weightStatus');
    const submitBtn = document.getElementById('submitBtn');
    
    totalWeightSpan.textContent = total + '%';
    
    if (total === 100) {
        weightStatus.innerHTML = '<span class="badge bg-success fs-6">✓ Total sudah benar (100%)</span>';
        submitBtn.disabled = false;
        submitBtn.classList.remove('btn-secondary');
        submitBtn.classList.add('btn-primary');
    } else {
        weightStatus.innerHTML = '<span class="badge bg-danger fs-6">✗ Total harus 100%</span>';
        submitBtn.disabled = true;
        submitBtn.classList.remove('btn-primary');
        submitBtn.classList.add('btn-secondary');
    }
}

// Add event listeners to weight inputs
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[name^="weights"]').forEach(input => {
        input.addEventListener('input', calculateTotal);
    });
    
    // Initial calculation
    calculateTotal();
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    let total = 0;
    document.querySelectorAll('input[name^="weights"]').forEach(input => {
        total += parseInt(input.value) || 0;
    });
    
    if (total !== 100) {
        e.preventDefault();
        alert('Total bobot harus 100%! Saat ini: ' + total + '%');
        return false;
    }
});
</script>
@endpush 