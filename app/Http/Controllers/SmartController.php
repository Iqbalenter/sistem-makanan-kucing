<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmartCalculationService;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Calculation;
use App\Models\Evaluation;

class SmartController extends Controller
{
    protected $smartService;

    public function __construct(SmartCalculationService $smartService)
    {
        $this->smartService = $smartService;
    }

    /**
     * Halaman utama dashboard
     */
    public function index()
    {
        $alternatives = Alternative::active()->get();
        $criteria = Criteria::active()->get();
        $hasCalculations = Calculation::exists();
        $rankings = $hasCalculations ? $this->smartService->getLatestRanking() : collect();

        return view('smart.index', compact('alternatives', 'criteria', 'hasCalculations', 'rankings'));
    }

    /**
     * Menjalankan perhitungan SMART
     */
    public function calculate()
    {
        try {
            $rankings = $this->smartService->calculate();
            
            return redirect()->route('smart.index')->with('success', 'Perhitungan SMART berhasil dilakukan!');
        } catch (\Exception $e) {
            return redirect()->route('smart.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan hasil ranking
     */
    public function rankings()
    {
        $rankings = $this->smartService->getLatestRanking();
        $criteria = Criteria::active()->get();

        return view('smart.rankings', compact('rankings', 'criteria'));
    }

    /**
     * Menampilkan detail perhitungan untuk alternatif tertentu
     */
    public function detail($alternativeId)
    {
        $detail = $this->smartService->getCalculationDetailForAlternative($alternativeId);
        
        if (!$detail['alternative']) {
            return redirect()->route('smart.rankings')->with('error', 'Alternatif tidak ditemukan.');
        }

        return view('smart.detail-new', compact('detail'));
    }

    /**
     * Menampilkan halaman perbandingan alternatif
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

        return view('smart.comparison', compact('comparisonData', 'criteria', 'chartData'));
    }

    /**
     * API endpoint untuk mendapatkan data rankings dalam format JSON
     */
    public function apiRankings()
    {
        $rankings = $this->smartService->getLatestRanking();
        
        return response()->json([
            'success' => true,
            'data' => $rankings
        ]);
    }

    /**
     * Halaman manajemen kriteria
     */
    public function criteriaManagement()
    {
        $criteria = Criteria::all();
        return view('smart.criteria', compact('criteria'));
    }

    /**
     * Update bobot kriteria
     */
    public function updateCriteriaWeights(Request $request)
    {
        $request->validate([
            'weights' => 'required|array',
            'weights.*' => 'required|integer|min:0|max:100'
        ]);

        $totalWeight = array_sum($request->weights);
        
        if ($totalWeight !== 100) {
            return redirect()->back()->with('error', 'Total bobot harus 100%');
        }

        try {
            foreach ($request->weights as $criteriaId => $weight) {
                $criteria = Criteria::findOrFail($criteriaId);
                $criteria->update([
                    'weight' => $weight,
                    'normalized_weight' => $weight / 100
                ]);
            }

            return redirect()->back()->with('success', 'Bobot kriteria berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Halaman manajemen alternatif
     */
    public function alternativeManagement()
    {
        $alternatives = Alternative::orderBy('code')->get();
        return view('smart.alternatives', compact('alternatives'));
    }

    /**
     * Show form untuk membuat alternatif baru
     */
    public function createAlternative()
    {
        // Generate kode alternatif baru dengan logic yang lebih robust
        $alternatives = Alternative::all();
        $maxNumber = 0;
        
        foreach ($alternatives as $alternative) {
            $number = intval(substr($alternative->code, 1));
            if ($number > $maxNumber) {
                $maxNumber = $number;
            }
        }
        
        $nextCode = 'A' . ($maxNumber + 1);
            
        return view('smart.create', compact('nextCode'));
    }

    /**
     * Store alternatif baru
     */
    public function storeAlternative(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'protein' => 'required|numeric|min:0|max:100',
            'fat' => 'required|numeric|min:0|max:100',
            'fiber' => 'required|numeric|min:0|max:100',
            'moisture' => 'required|numeric|min:0|max:100',
            'price' => 'required|integer|min:0',
            'brand' => 'required|string|max:255',
            'size' => 'required|string|max:50',
            'is_active' => 'boolean'
        ]);

        try {
            // Generate kode alternatif baru dengan logic yang lebih robust
            $alternatives = Alternative::all();
            $maxNumber = 0;
            
            foreach ($alternatives as $alternative) {
                $number = intval(substr($alternative->code, 1));
                if ($number > $maxNumber) {
                    $maxNumber = $number;
                }
            }
            
            $code = 'A' . ($maxNumber + 1);

            // Double check untuk memastikan kode tidak duplikat
            while (Alternative::where('code', $code)->exists()) {
                $maxNumber++;
                $code = 'A' . ($maxNumber + 1);
            }

            Alternative::create([
                'code' => $code,
                'name' => $request->name,
                'description' => $request->description,
                'protein' => $request->protein,
                'fat' => $request->fat,
                'fiber' => $request->fiber,
                'moisture' => $request->moisture,
                'price' => $request->price,
                'brand' => $request->brand,
                'size' => $request->size,
                'is_active' => $request->boolean('is_active', true)
            ]);

            return redirect()->route('smart.alternatives')->with('success', 'Alternatif makanan kucing berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show detail alternatif
     */
    public function showAlternative($id)
    {
        $alternative = Alternative::findOrFail($id);
        $latestCalculation = $alternative->latestCalculation;
        
        return view('smart.show', compact('alternative', 'latestCalculation'));
    }

    /**
     * Show form untuk edit alternatif
     */
    public function editAlternative($id)
    {
        $alternative = Alternative::findOrFail($id);
        return view('smart.edit', compact('alternative'));
    }

    /**
     * Update alternatif
     */
    public function updateAlternative(Request $request, $id)
    {
        $alternative = Alternative::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'protein' => 'required|numeric|min:0|max:100',
            'fat' => 'required|numeric|min:0|max:100',
            'fiber' => 'required|numeric|min:0|max:100',
            'moisture' => 'required|numeric|min:0|max:100',
            'price' => 'required|integer|min:0',
            'brand' => 'required|string|max:255',
            'size' => 'required|string|max:50',
            'is_active' => 'boolean'
        ]);

        try {
            $alternative->update([
                'name' => $request->name,
                'description' => $request->description,
                'protein' => $request->protein,
                'fat' => $request->fat,
                'fiber' => $request->fiber,
                'moisture' => $request->moisture,
                'price' => $request->price,
                'brand' => $request->brand,
                'size' => $request->size,
                'is_active' => $request->boolean('is_active', true)
            ]);

            return redirect()->route('smart.alternatives')->with('success', 'Data alternatif berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete alternatif
     */
    public function destroyAlternative($id)
    {
        try {
            $alternative = Alternative::findOrFail($id);
            
            // Hapus evaluations dan calculations terkait
            $alternative->evaluations()->delete();
            $alternative->calculations()->delete();
            
            $alternative->delete();

            return redirect()->route('smart.alternatives')->with('success', 'Alternatif berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
