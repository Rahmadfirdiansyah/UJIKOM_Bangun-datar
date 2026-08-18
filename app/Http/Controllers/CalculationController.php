<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    /**
     * Menampilkan form tampilan calculate.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('calculate');
    }

    /**
     * Menangani perhitungan rumus dan menyimpan data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari formulir
        $request->validate([
            'name' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'flatShape' => 'nullable|string',
            'solidShape' => 'nullable|string',
            'flatDimensions' => 'nullable|array',
            'solidDimensions' => 'nullable|array',
        ]);

        $data = $request->all();

        $calculationData = [
            'name' => $data['name'],
            'school' => $data['school'],
            'age' => $data['age'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'bangun_datar' => null,
            'bangun_ruang' => null,
            'result' => '-',
        ];

        if ($request->filled('flatShape') && isset($data['flatDimensions'])) {
            $calculationData['bangun_datar'] = $this->calculateResult($data['flatShape'], $data['flatDimensions']);
        }

        if ($request->filled('solidShape') && isset($data['solidDimensions'])) {
            $calculationData['bangun_ruang'] = $this->calculateResult($data['solidShape'], $data['solidDimensions']);
        }

        // Set kolom 'result' sebagai penggabungan hasil kalkulasi
        $resultsList = array_filter([
            $calculationData['bangun_datar'],
            $calculationData['bangun_ruang'],
        ]);

        $calculationData['result'] = !empty($resultsList) ? implode(' | ', $resultsList) : 'Tanpa Perhitungan';

        Calculation::create($calculationData);

        return redirect()->route('data.index')->with('success', 'Data perhitungan berhasil disimpan!');
    }

    /**
     * Memproses kalkulasi hasil berdasarkan bentuk dan dimensi.
     *
     * @param string $shape
     * @param array $dimensions
     * @return string
     */
    private function calculateResult($shape, $dimensions)
    {
        switch ($shape) {
            case 'square':
                $side = floatval($dimensions['side'] ?? 0);
                $area = $side * $side;
                return "Persegi (s = {$side}) → Luas: {$area}";

            case 'triangle':
                $base = floatval($dimensions['base'] ?? 0);
                $height = floatval($dimensions['height'] ?? 0);
                $area = 0.5 * $base * $height;
                return "Segitiga (a = {$base}, t = {$height}) → Luas: {$area}";

            case 'circle':
                $radius = floatval($dimensions['radius'] ?? 0);
                $area = pi() * $radius * $radius;
                $areaFormatted = round($area, 2);
                return "Lingkaran (r = {$radius}) → Luas: {$areaFormatted}";

            case 'cube':
                $side = floatval($dimensions['side'] ?? 0);
                $volume = $side * $side * $side;
                return "Kubus (s = {$side}) → Volume: {$volume}";

            case 'pyramid':
                $baseArea = floatval($dimensions['base_area'] ?? 0);
                $height = floatval($dimensions['height'] ?? 0);
                $volume = (1/3) * $baseArea * $height;
                $volumeFormatted = round($volume, 2);
                return "Limas (La = {$baseArea}, t = {$height}) → Volume: {$volumeFormatted}";

            case 'cylinder':
                $radius = floatval($dimensions['radius'] ?? 0);
                $height = floatval($dimensions['height'] ?? 0);
                $volume = pi() * $radius * $radius * $height;
                $volumeFormatted = round($volume, 2);
                return "Tabung (r = {$radius}, t = {$height}) → Volume: {$volumeFormatted}";

            default:
                return "Hasil tidak valid";
        }
    }

    /**
     * Menampilkan daftar data perhitungan.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $calculations = Calculation::latest()->get();
        return view('data', compact('calculations'));
    }

    /**
     * Mengurutkan data berdasarkan kolom tertentu.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function sort(Request $request)
    {
        $sortBy = $request->input('sort_by', 'created_at');
        $allowedSorts = ['created_at', 'name', 'school', 'age', 'address', 'phone', 'bangun_datar', 'bangun_ruang', 'result'];
        
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        $calculations = Calculation::orderBy($sortBy, 'desc')->get();
        return view('data', compact('calculations'));
    }

    /**
     * Menampilkan statistik perhitungan.
     *
     * @return \Illuminate\View\View
     */
    public function stats()
    {
        $calculations = Calculation::all();
        $totalCalculations = $calculations->count();

        $flatCount = $calculations->whereNotNull('bangun_datar')->where('bangun_datar', '!=', '')->count();
        $solidCount = $calculations->whereNotNull('bangun_ruang')->where('bangun_ruang', '!=', '')->count();

        $flatPercentage = $totalCalculations > 0 ? ($flatCount / $totalCalculations) * 100 : 0;
        $solidPercentage = $totalCalculations > 0 ? ($solidCount / $totalCalculations) * 100 : 0;

        $shapeCounts = [
            'Persegi' => 0,
            'Segitiga' => 0,
            'Lingkaran' => 0,
            'Kubus' => 0,
            'Limas' => 0,
            'Tabung' => 0,
        ];

        foreach ($calculations as $item) {
            if (!empty($item->bangun_datar)) {
                $str = strtolower($item->bangun_datar);
                if (str_contains($str, 'persegi') || str_contains($str, 'square')) {
                    $shapeCounts['Persegi']++;
                } elseif (str_contains($str, 'segitiga') || str_contains($str, 'triangle')) {
                    $shapeCounts['Segitiga']++;
                } elseif (str_contains($str, 'lingkaran') || str_contains($str, 'circle')) {
                    $shapeCounts['Lingkaran']++;
                }
            }
            if (!empty($item->bangun_ruang)) {
                $str = strtolower($item->bangun_ruang);
                if (str_contains($str, 'kubus') || str_contains($str, 'cube')) {
                    $shapeCounts['Kubus']++;
                } elseif (str_contains($str, 'limas') || str_contains($str, 'pyramid')) {
                    $shapeCounts['Limas']++;
                } elseif (str_contains($str, 'tabung') || str_contains($str, 'cylinder')) {
                    $shapeCounts['Tabung']++;
                }
            }
        }

        $shapePercentages = collect($shapeCounts)->map(function ($count) use ($totalCalculations) {
            return $totalCalculations > 0 ? ($count / $totalCalculations) * 100 : 0;
        });

        return view('stats', compact('totalCalculations', 'flatCount', 'solidCount', 'flatPercentage', 'solidPercentage', 'shapeCounts', 'shapePercentages'));
    }
}
