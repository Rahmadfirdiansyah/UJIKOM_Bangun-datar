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

        Calculation::create($data);

        return redirect()->route('data.index');
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


    public function sort(Request $request)
{
    $sortBy = $request->input('sort_by', 'created_at');
    $calculations = Calculation::orderBy($sortBy)->get();
    return view('data', compact('calculations'));
}

public function stats()
{
    $calculations = Calculation::all();
    return view('stats', compact('calculations'));
}

}
