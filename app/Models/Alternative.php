<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $table = 'alternatives';

    protected $fillable = [
        'code',
        'name',
        'description',
        'protein',
        'fat',
        'fiber',
        'moisture',
        'price',
        'brand',
        'size',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'protein' => 'decimal:2',
        'fat' => 'decimal:2',
        'fiber' => 'decimal:2',
        'moisture' => 'decimal:2',
        'price' => 'integer'
    ];

    // Relasi ke evaluations
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    // Relasi ke calculations
    public function calculations()
    {
        return $this->hasMany(Calculation::class);
    }

    // Method untuk mendapatkan perhitungan terbaru
    public function latestCalculation()
    {
        return $this->hasOne(Calculation::class)->latest('calculated_at');
    }

    // Scope untuk alternatif aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Method untuk format harga
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Method untuk mendapatkan nilai berdasarkan kriteria
    public function getValueByCriteria($criteriaCode)
    {
        switch ($criteriaCode) {
            case 'C1': return $this->protein;
            case 'C2': return $this->fat;
            case 'C3': return $this->fiber;
            case 'C4': return $this->moisture;
            case 'C5': return $this->price;
            default: return 0;
        }
    }
}
