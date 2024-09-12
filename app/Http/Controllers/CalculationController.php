<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    /**
     * Show the form for calculating.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('calculate');
    }

    /**
     * Handle the calculation and store the data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'school' => 'required|string',
            'age' => 'required|integer',
            'address' => 'required|string',
            'phone' => 'required|string',
            'shape' => 'required|string',
            'dimensions' => 'required|array'
        ]);

        $data = $request->all();
        $data['dimensions'] = json_encode($data['dimensions']);
        $data['result'] = $this->calculateResult($data['shape'], $data['dimensions']);

        Calculation::create($data);

        return redirect()->route('data.index');
    }

    /**
     * Calculate the result based on shape and dimensions.
     *
     * @param string $shape
     * @param string $dimensionsJson
     * @return string
     */
    private function calculateResult($shape, $dimensionsJson)
    {
        $dimensions = json_decode($dimensionsJson, true);
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
        $calculations = Calculation::all();
        $totalCalculations = $calculations->count();

        $shapeCounts = $calculations->groupBy('shape')->map->count();
        $shapePercentages = $shapeCounts->map(fn($count) => ($count / $totalCalculations) * 100);

        return view('stats', compact('totalCalculations', 'shapeCounts', 'shapePercentages'));
    }
}
