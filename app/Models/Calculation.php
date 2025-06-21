<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    use HasFactory;

    protected $table = 'calculations';

    protected $fillable = [
        'alternative_id',
        'final_score',
        'rank',
        'calculation_details',
        'calculated_at'
    ];

    protected $casts = [
        'final_score' => 'decimal:6',
        'rank' => 'integer',
        'calculation_details' => 'array',
        'calculated_at' => 'datetime'
    ];

    // Relasi ke alternative
    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }

    // Scope untuk mendapatkan ranking terbaru
    public function scopeLatestRanking($query)
    {
        return $query->orderBy('rank', 'asc')->orderBy('calculated_at', 'desc');
    }

    // Method untuk format skor
    public function getFormattedScoreAttribute()
    {
        return number_format($this->final_score, 6);
    }
}
