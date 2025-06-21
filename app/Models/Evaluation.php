<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'evaluations';

    protected $fillable = [
        'alternative_id',
        'criteria_id',
        'raw_value',
        'utility_value',
        'weighted_value'
    ];

    protected $casts = [
        'raw_value' => 'decimal:2',
        'utility_value' => 'decimal:6',
        'weighted_value' => 'decimal:6'
    ];

    // Relasi ke alternative
    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }

    // Relasi ke criteria
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
