<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    /**
     * menapilkan form tampilan calculate"
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('calculate');// Mengembalikan tampilan 'calculate'halaman depan yang berisi formulir input
    }

    /**
     * menangani perhitungan rumus atau program dan menyimpan data
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi input dari formulir
        $request->validate([
            'name' => 'required|string',        //Nama siswa
            'school' => 'required|string',      //Nama sekolah
            'age' => 'required|integer',        //Umur
            'address' => 'required|string',     //Allamat
            'phone' => 'required|string',       //nomer telepon
            'shape' => 'required|string',       //Jenis bangun (misalnya, persegi, segitiga, dll
            'dimensions' => 'required|array'    // Dimensi bangun (seperti panjang sisi, jari-jari, dll.)
        ]);

        // Mengambil semua data dari formulir
        $data = $request->all();

        // Mengonversi array dimensi menjadi JSON
        $data['dimensions'] = json_encode($data['dimensions']);

        // Menghitung hasil berdasarkan bentuk dan dimensi
        $data['result'] = $this->calculateResult($data['shape'], $data['dimensions']);

        // Menyimpan data ke database menggunakan model Calculation
        Calculation::create($data);

        // Mengarahkan pengguna ke rute 'data.index' setelah penyimpanan berhasil
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
