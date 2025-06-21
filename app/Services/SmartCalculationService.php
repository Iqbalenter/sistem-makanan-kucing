<?php

namespace App\Services;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\Calculation;
use Illuminate\Support\Facades\DB;

class SmartCalculationService
{
    /**
     * Menjalankan perhitungan SMART untuk semua alternatif
     * 
     * @return array
     */
    public function calculate()
    {
        // Ambil semua kriteria dan alternatif yang aktif
        $criteria = Criteria::active()->get();
        $alternatives = Alternative::active()->get();

        // Hapus perhitungan lama
        Evaluation::truncate();
        Calculation::truncate();

        // Hitung nilai utility untuk setiap alternatif dan kriteria
        $this->calculateUtilityValues($alternatives, $criteria);

        // Hitung skor akhir dan ranking
        $rankings = $this->calculateFinalScores($alternatives, $criteria);

        return $rankings;
    }

    /**
     * Menghitung nilai utility untuk setiap alternatif dan kriteria
     * 
     * @param \Illuminate\Database\Eloquent\Collection $alternatives
     * @param \Illuminate\Database\Eloquent\Collection $criteria
     */
    private function calculateUtilityValues($alternatives, $criteria)
    {
        foreach ($criteria as $criterion) {
            // Ambil semua nilai untuk kriteria ini
            $values = [];
            foreach ($alternatives as $alternative) {
                $values[] = $alternative->getValueByCriteria($criterion->code);
            }

            $minValue = min($values);
            $maxValue = max($values);

            // Hitung utility value untuk setiap alternatif pada kriteria ini
            foreach ($alternatives as $alternative) {
                $rawValue = $alternative->getValueByCriteria($criterion->code);
                
                // Hitung utility value berdasarkan jenis kriteria
                if ($criterion->type === 'benefit') {
                    // Untuk benefit: semakin tinggi semakin baik
                    $utilityValue = ($maxValue == $minValue) ? 1 : ($rawValue - $minValue) / ($maxValue - $minValue);
                } else {
                    // Untuk cost: semakin rendah semakin baik
                    $utilityValue = ($maxValue == $minValue) ? 1 : ($maxValue - $rawValue) / ($maxValue - $minValue);
                }

                // Hitung weighted value
                $weightedValue = $utilityValue * $criterion->normalized_weight;

                // Simpan ke database
                Evaluation::create([
                    'alternative_id' => $alternative->id,
                    'criteria_id' => $criterion->id,
                    'raw_value' => $rawValue,
                    'utility_value' => $utilityValue,
                    'weighted_value' => $weightedValue
                ]);
            }
        }
    }

    /**
     * Menghitung skor akhir dan ranking
     * 
     * @param \Illuminate\Database\Eloquent\Collection $alternatives
     * @param \Illuminate\Database\Eloquent\Collection $criteria
     * @return array
     */
    private function calculateFinalScores($alternatives, $criteria)
    {
        $scores = [];

        foreach ($alternatives as $alternative) {
            // Hitung total skor untuk alternatif ini
            $totalScore = Evaluation::where('alternative_id', $alternative->id)
                ->sum('weighted_value');

            $scores[] = [
                'alternative' => $alternative,
                'score' => $totalScore
            ];

            // Simpan ke tabel calculations
            Calculation::create([
                'alternative_id' => $alternative->id,
                'final_score' => $totalScore,
                'rank' => 0, // Akan diupdate setelah sorting
                'calculation_details' => $this->getCalculationDetails($alternative->id),
                'calculated_at' => now()
            ]);
        }

        // Sort berdasarkan skor dari tinggi ke rendah
        usort($scores, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Update ranking
        foreach ($scores as $index => $score) {
            Calculation::where('alternative_id', $score['alternative']->id)
                ->update(['rank' => $index + 1]);
        }

        return $scores;
    }

    /**
     * Mendapatkan detail perhitungan untuk debugging
     * 
     * @param int $alternativeId
     * @return array
     */
    private function getCalculationDetails($alternativeId)
    {
        $evaluations = Evaluation::with('criteria')
            ->where('alternative_id', $alternativeId)
            ->get();

        $details = [];
        foreach ($evaluations as $evaluation) {
            $details[] = [
                'criteria' => $evaluation->criteria->name,
                'raw_value' => $evaluation->raw_value,
                'utility_value' => $evaluation->utility_value,
                'weight' => $evaluation->criteria->normalized_weight,
                'weighted_value' => $evaluation->weighted_value
            ];
        }

        return $details;
    }

    /**
     * Mendapatkan hasil ranking terbaru
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLatestRanking()
    {
        return Calculation::with('alternative')
            ->orderBy('rank', 'asc')
            ->get();
    }

    /**
     * Mendapatkan detail perhitungan untuk alternatif tertentu
     * 
     * @param int $alternativeId
     * @return array
     */
    public function getCalculationDetailForAlternative($alternativeId)
    {
        $alternative = Alternative::find($alternativeId);
        $evaluations = Evaluation::with(['criteria'])
            ->where('alternative_id', $alternativeId)
            ->get();

        $calculation = Calculation::where('alternative_id', $alternativeId)->first();

        // Hitung range min/max untuk setiap kriteria
        $ranges = [];
        $criteria = Criteria::active()->get();
        
        foreach ($criteria as $criterion) {
            $allValues = Evaluation::where('criteria_id', $criterion->id)->pluck('raw_value');
            $ranges[$criterion->id] = [
                'min' => $allValues->min() ?? 0,
                'max' => $allValues->max() ?? 0
            ];
        }

        return [
            'alternative' => $alternative,
            'evaluations' => $evaluations,
            'calculation' => $calculation,
            'ranges' => $ranges
        ];
    }
} 