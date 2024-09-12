<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    /**
     * Menampilkan form tampilan calculate.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('calculate'); // Mengembalikan tampilan 'calculate' halaman depan yang berisi formulir input
    }

    /**
     * Menangani perhitungan rumus atau program dan menyimpan data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input dari formulir
        $request->validate([
            'name' => 'required|string',
            'school' => 'required|string',
            'age' => 'required|integer',
            'address' => 'required|string',
            'phone' => 'required|string',
            'flatShape' => 'nullable|string',      // Jenis bangun datar
            'solidShape' => 'nullable|string',     // Jenis bangun ruang
            'flatDimensions' => 'nullable|array',  // Dimensi bangun datar
            'solidDimensions' => 'nullable|array', // Dimensi bangun ruang
        ]);

        // Mengambil data dari input formulir
        $data = $request->all();

        // Proses penyimpanan bangun datar (jika ada)
        if ($request->filled('flatShape')) {
            $flatData = [
                'name' => $data['name'],
                'school' => $data['school'],
                'age' => $data['age'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'shape' => $data['flatShape'],
                'dimensions' => json_encode($data['flatDimensions']),
                'result' => $this->calculateResult($data['flatShape'], $data['flatDimensions']),
            ];
            Calculation::create($flatData);
        }

        // Proses penyimpanan bangun ruang (jika ada)
        if ($request->filled('solidShape')) {
            $solidData = [
                'name' => $data['name'],
                'school' => $data['school'],
                'age' => $data['age'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'shape' => $data['solidShape'],
                'dimensions' => json_encode($data['solidDimensions']),
                'result' => $this->calculateResult($data['solidShape'], $data['solidDimensions']),
            ];
            Calculation::create($solidData);
        }

        // Redirect ke rute yang sesuai setelah data berhasil disimpan
        return redirect()->route('data.index')->with('success', 'Data perhitungan berhasil disimpan');
    }

    /**
     * Calculate the result based on shape and dimensions.
     *
     * @param string $shape
     * @param array $dimensions
     * @return string
     */
    private function calculateResult($shape, $dimensions)
    {
        switch ($shape) {
            case 'square':
                $side = $dimensions['side'];
                $area = $side * $side;
                return "Luas: $area";

            case 'triangle':
                $base = $dimensions['base'];
                $height = $dimensions['height'];
                $area = 0.5 * $base * $height;
                return "Luas: $area";

            case 'circle':
                $radius = $dimensions['radius'];
                $area = pi() * $radius * $radius;
                return "Luas: $area";

            case 'cube':
                $side = $dimensions['side'];
                $volume = $side * $side * $side;
                return "Volume: $volume";

            case 'pyramid':
                $baseArea = $dimensions['base_area'];
                $height = $dimensions['height'];
                $volume = (1/3) * $baseArea * $height;
                return "Volume: $volume";

            case 'cylinder':
                $radius = $dimensions['radius'];
                $height = $dimensions['height'];
                $volume = pi() * $radius * $radius * $height;
                return "Volume: $volume";

            default:
                return "Hasil tidak valid";
        }
    }

    /**
     * Display a listing of the data.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $calculations = Calculation::all();
        return view('data', compact('calculations'));
    }

    /**
     * Sort the data based on a given column.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        $sortBy = $request->input('sort_by', 'created_at');
        $calculations = Calculation::orderBy($sortBy)->get();
        return view('data', compact('calculations'));
    }

    /**
     * Display statistics based on calculations.
     *
     * @return \Illuminate\Http\Response
     */
    public function stats()
    {
        // Mengambil semua data perhitungan
        $calculations = Calculation::all();
        
        // Jumlah total penghitungan luas dan volume yang sudah dilakukan
        $totalCalculations = $calculations->count();

        // Mengelompokkan berdasarkan jenis bangun (datar atau ruang)
        $flatShapes = ['square', 'triangle', 'circle']; // Bangun datar
        $solidShapes = ['cube', 'pyramid', 'cylinder']; // Bangun ruang

        // Mengelompokkan dan menghitung jumlah masing-masing bentuk
        $shapeCounts = $calculations->groupBy('shape')->map->count();

        // Menghitung persentase untuk bangun datar
        $flatCount = $calculations->whereIn('shape', $flatShapes)->count();
        $flatPercentage = $totalCalculations > 0 ? ($flatCount / $totalCalculations) * 100 : 0;

        // Menghitung persentase untuk bangun ruang
        $solidCount = $calculations->whereIn('shape', $solidShapes)->count();
        $solidPercentage = $totalCalculations > 0 ? ($solidCount / $totalCalculations) * 100 : 0;

        // Menghitung persentase masing-masing bentuk
        $shapePercentages = $shapeCounts->map(function ($count) use ($totalCalculations) {
            return $totalCalculations > 0 ? ($count / $totalCalculations) * 100 : 0;
        });

        return view('stats', compact('totalCalculations', 'flatPercentage', 'solidPercentage', 'shapeCounts', 'shapePercentages'));
    }
}
