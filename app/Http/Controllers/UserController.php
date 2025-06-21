<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\Calculation;
use App\Services\SmartCalculationService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $smartService;

    public function __construct(SmartCalculationService $smartService)
    {
        $this->smartService = $smartService;
    }

    /**
     * Show user dashboard
     */
    public function dashboard()
    {
        return view('user.dashboard');
    }

    /**
     * Show rankings for users (read-only)
     */
    public function rankings()
    {
        $rankings = $this->smartService->getLatestRanking();
        $criteria = Criteria::active()->get();
        
        return view('user.rankings', compact('rankings', 'criteria'));
    }

    /**
     * Show comparison for users (read-only)
     */
    public function comparison()
    {
        // Ambil hanya alternatif yang sudah memiliki data evaluasi
        $alternativesWithEvaluations = Alternative::active()
            ->whereHas('evaluations')
            ->get();
            
        $criteria = Criteria::active()->get();
        $evaluations = Evaluation::with(['alternative', 'criteria'])
            ->whereIn('alternative_id', $alternativesWithEvaluations->pluck('id'))
            ->get();

        // Group evaluations by alternative
        $comparisonData = [];
        $chartData = [
            'alternatives' => [],
            'criteria' => [],
            'rawData' => [],
            'utilityData' => []
        ];

        foreach ($alternativesWithEvaluations as $alternative) {
            $alternativeEvaluations = $evaluations->where('alternative_id', $alternative->id)->keyBy('criteria_id');
            
            // Pastikan alternatif memiliki evaluasi untuk semua kriteria
            if ($alternativeEvaluations->count() == $criteria->count()) {
                $comparisonData[$alternative->id] = [
                    'alternative' => $alternative,
                    'evaluations' => $alternativeEvaluations
                ];

                // Prepare chart data
                $chartData['alternatives'][] = $alternative->name;
                $rawValues = [];
                $utilityValues = [];
                
                foreach ($criteria as $criterion) {
                    $evaluation = $alternativeEvaluations->get($criterion->id);
                    
                    $rawValues[] = $evaluation ? $evaluation->raw_value : 0;
                    $utilityValues[] = $evaluation ? $evaluation->utility_value : 0;
                }
                
                $chartData['rawData'][] = $rawValues;
                $chartData['utilityData'][] = $utilityValues;
            }
        }

        $chartData['criteria'] = $criteria->pluck('name');

        return view('user.comparison', compact('comparisonData', 'criteria', 'chartData'));
    }

    /**
     * Show detail alternatif untuk user
     */
    public function detail($alternativeId)
    {
        $detail = $this->smartService->getCalculationDetailForAlternative($alternativeId);
        
        if (!$detail['alternative']) {
            return redirect()->route('user.rankings')->with('error', 'Alternatif tidak ditemukan.');
        }

        return view('user.detail', compact('detail'));
    }
}
