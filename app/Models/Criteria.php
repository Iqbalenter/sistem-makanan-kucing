<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $table = 'criteria';

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'weight',
        'normalized_weight',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'weight' => 'integer',
        'normalized_weight' => 'decimal:4'
    ];

    // Relasi ke evaluations
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    // Scope untuk kriteria aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Method untuk mengecek apakah kriteria benefit atau cost
    public function isBenefit()
    {
        return $this->type === 'benefit';
    }

    public function isCost()
    {
        return $this->type === 'cost';
    }
}
