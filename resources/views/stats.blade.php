@extends('layouts.app')

@section('title', 'Statistik Perhitungan')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Header Banner -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Statistik Perhitungan Geometri</h1>
            <p class="text-xs text-slate-500 mt-1">Ringkasan analitik dan distribusi penggunaan kalkulator bangun datar & ruang</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('calculate.index') }}" 
               class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                <i class="fa-solid fa-calculator"></i> Form Perhitungan
            </a>
            <a href="{{ route('data.index') }}" 
               class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition flex items-center gap-2">
                <i class="fa-solid fa-table-cells"></i> Dashboard Data
            </a>
        </div>
    </div>

    <!-- Metric Card 1: Total Calculations -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 rounded-3xl p-8 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <div class="space-y-2 text-center sm:text-left z-10">
            <span class="px-3 py-1 bg-white/10 text-blue-300 rounded-full text-xs font-bold uppercase tracking-wider">
                Overview Metrik
            </span>
            <h2 class="text-3xl font-extrabold tracking-tight">Total Perhitungan Tersimpan</h2>
            <p class="text-xs text-slate-300">Jumlah total seluruh kalkulasi geometri yang dilakukan pengguna</p>
        </div>
        <div class="flex items-center gap-4 z-10">
            <div class="text-right">
                <span class="text-5xl font-black text-blue-400 tracking-tight">{{ $totalCalculations }}</span>
                <span class="block text-xs text-slate-400 font-semibold uppercase">Kalkulasi</span>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-blue-500/20 border border-blue-400/30 flex items-center justify-center text-blue-400 text-2xl">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>
        <div class="absolute right-0 bottom-0 opacity-10 text-9xl font-black text-white pointer-events-none">
            <i class="fa-solid fa-chart-pie"></i>
        </div>
    </div>

    <!-- Category Distribution Grid (Bangun Datar vs Bangun Ruang) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Bangun Datar Card -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-vector-square text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Bangun Datar</h3>
                        <p class="text-xs text-slate-500">{{ $flatCount ?? 0 }} Perhitungan Luas</p>
                    </div>
                </div>
                <span class="text-xl font-extrabold text-emerald-600">
                    {{ number_format($flatPercentage, 1) }}%
                </span>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                <div class="bg-emerald-500 h-full rounded-full transition-all duration-1000" style="width: {{ $flatPercentage }}%"></div>
            </div>
        </div>

        <!-- Bangun Ruang Card -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-cube text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Bangun Ruang</h3>
                        <p class="text-xs text-slate-500">{{ $solidCount ?? 0 }} Perhitungan Volume</p>
                    </div>
                </div>
                <span class="text-xl font-extrabold text-indigo-600">
                    {{ number_format($solidPercentage, 1) }}%
                </span>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                <div class="bg-indigo-500 h-full rounded-full transition-all duration-1000" style="width: {{ $solidPercentage }}%"></div>
            </div>
        </div>
    </div>

    <!-- Detailed Shape Breakdown -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-4 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Detail Persentase per Bentuk Geometri</h3>
                <p class="text-xs text-slate-500">Frekuensi perhitungan setiap bentuk bangun datar dan bangun ruang</p>
            </div>
            <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-100 text-slate-600">
                6 Bentuk Terdaftar
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $shapeIcons = [
                    'Persegi' => ['icon' => 'fa-square', 'color' => 'emerald', 'type' => 'Datar', 'formula' => 's × s'],
                    'Segitiga' => ['icon' => 'fa-play', 'color' => 'emerald', 'type' => 'Datar', 'formula' => '½ × a × t'],
                    'Lingkaran' => ['icon' => 'fa-circle', 'color' => 'emerald', 'type' => 'Datar', 'formula' => 'π × r²'],
                    'Kubus' => ['icon' => 'fa-cube', 'color' => 'indigo', 'type' => 'Ruang', 'formula' => 's³'],
                    'Limas' => ['icon' => 'fa-pyramid', 'color' => 'indigo', 'type' => 'Ruang', 'formula' => '⅓ × La × t'],
                    'Tabung' => ['icon' => 'fa-database', 'color' => 'indigo', 'type' => 'Ruang', 'formula' => 'π × r² × t'],
                ];
            @endphp

            @foreach ($shapeCounts as $shape => $count)
                @php
                    $percentage = $totalCalculations > 0 ? ($count / $totalCalculations) * 100 : 0;
                    $meta = $shapeIcons[$shape] ?? ['icon' => 'fa-shapes', 'color' => 'blue', 'type' => 'Geometri', 'formula' => '-'];
                    $colorClass = $meta['color'] === 'emerald' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-indigo-50 text-indigo-700 border-indigo-200';
                    $barColor = $meta['color'] === 'emerald' ? 'bg-emerald-500' : 'bg-indigo-500';
                @endphp

                <div class="p-5 rounded-2xl border border-slate-200/80 bg-slate-50/50 space-y-3 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center font-bold text-xs border {{ $colorClass }}">
                                <i class="fa-solid {{ $meta['icon'] }}"></i>
                            </span>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">{{ $shape }}</h4>
                                <span class="text-[10px] text-slate-400">Rumus: {{ $meta['formula'] }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-black text-sm text-slate-900">{{ number_format($percentage, 1) }}%</span>
                            <span class="block text-[10px] text-slate-400">{{ $count }}x dihitung</span>
                        </div>
                    </div>

                    <!-- Small Progress Bar -->
                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                        <div class="{{ $barColor }} h-full rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
