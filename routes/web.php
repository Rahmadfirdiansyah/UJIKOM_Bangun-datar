<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculationController;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CalculationController::class, 'index'])->name('calculate.index');
Route::post('/store', [CalculationController::class, 'store'])->name('calculate.store');
Route::get('/data', [CalculationController::class, 'show'])->name('data.index');
Route::get('/data/sort', [CalculationController::class, 'sort'])->name('data.sort');
Route::get('/stats', [CalculationController::class, 'stats'])->name('stats.index');
route::get('/data/sort', [CalculationController::class, 'sort'])->name('data.sort');
route::get('/stats', [CalculationController::class, 'stats'])->name('stats');
