@extends('layouts.app')

@section('title', 'Hitung Luas & Volume')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header Page Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl shadow-blue-500/10 relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl font-extrabold tracking-tight">Kalkulator Bangun Datar & Ruang</h1>
            <p class="mt-2 text-blue-100 text-sm max-w-xl">
                Isi biodata siswa dan pilih bangun geometri yang ingin dihitung. Sistem akan menghitung luas dan volume secara akurat.
            </p>
        </div>
        <div class="absolute -right-8 -bottom-8 opacity-10 text-9xl font-black text-white pointer-events-none">
            <i class="fa-solid fa-calculator"></i>
        </div>
    </div>

    <form action="{{ route('calculate.store') }}" method="POST" class="space-y-8">
        @csrf

        <!-- Card 1: Biodata Siswa -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-6">
            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-id-card text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Biodata Siswa</h2>
                    <p class="text-xs text-slate-500">Lengkapi data pribadi siswa sebelum memulai perhitungan</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <input type="text" id="name" name="name" required placeholder="Contoh: Ahmad Rizky" 
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition">
                    </div>
                </div>

                <!-- Sekolah -->
                <div>
                    <label for="school" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Nama Sekolah <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <input type="text" id="school" name="school" required placeholder="Contoh: SMKN 1 Jakarta" 
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition">
                    </div>
                </div>

                <!-- Usia -->
                <div>
                    <label for="age" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Usia (Tahun) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-cake-candles"></i>
                        </div>
                        <input type="number" id="age" name="age" min="1" max="120" required placeholder="Contoh: 17" 
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition">
                    </div>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <input type="text" id="phone" name="phone" required placeholder="Contoh: 081234567890" 
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition">
                    </div>
                </div>

                <!-- Alamat (Full Width) -->
                <div class="sm:col-span-2">
                    <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Alamat Rumah <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <input type="text" id="address" name="address" required placeholder="Contoh: Jl. Merdeka No. 45, Jakarta Pusat" 
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition">
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Grid: Bangun Datar & Bangun Ruang -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Card 2: Bangun Datar -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-6 flex flex-col justify-between">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-vector-square text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Bangun Datar</h2>
                            <p class="text-xs text-slate-500">Kalkulasi Luas bidang 2 Dimensi</p>
                        </div>
                    </div>

                    <div>
                        <label for="flatShape" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Pilih Bentuk Bangun Datar
                        </label>
                        <select id="flatShape" name="flatShape" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-none transition">
                            <option value="">-- Pilih Bangun Datar (Opsional) --</option>
                            <option value="square">Persegi (Square)</option>
                            <option value="triangle">Segitiga (Triangle)</option>
                            <option value="circle">Lingkaran (Circle)</option>
                        </select>
                    </div>

                    <!-- Formula Info Card -->
                    <div id="flatFormulaInfo" class="hidden p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-900 flex items-start gap-3">
                        <i class="fa-solid fa-circle-info text-emerald-600 text-sm mt-0.5"></i>
                        <div id="flatFormulaText"></div>
                    </div>

                    <!-- Dynamic Input Container -->
                    <div id="flatDimensions" class="space-y-4"></div>
                </div>
            </div>

            <!-- Card 3: Bangun Ruang -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-6 flex flex-col justify-between">
                <div class="space-y-6">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-cube text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Bangun Ruang</h2>
                            <p class="text-xs text-slate-500">Kalkulasi Volume ruang 3 Dimensi</p>
                        </div>
                    </div>

                    <div>
                        <label for="solidShape" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Pilih Bentuk Bangun Ruang
                        </label>
                        <select id="solidShape" name="solidShape" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:bg-white focus:outline-none transition">
                            <option value="">-- Pilih Bangun Ruang (Opsional) --</option>
                            <option value="cube">Kubus (Cube)</option>
                            <option value="pyramid">Limas (Pyramid)</option>
                            <option value="cylinder">Tabung (Cylinder)</option>
                        </select>
                    </div>

                    <!-- Formula Info Card -->
                    <div id="solidFormulaInfo" class="hidden p-4 rounded-2xl bg-indigo-50 border border-indigo-200 text-xs text-indigo-900 flex items-start gap-3">
                        <i class="fa-solid fa-circle-info text-indigo-600 text-sm mt-0.5"></i>
                        <div id="solidFormulaText"></div>
                    </div>

                    <!-- Dynamic Input Container -->
                    <div id="solidDimensions" class="space-y-4"></div>
                </div>
            </div>
        </div>

        <!-- Submit & Quick Action Bar -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs text-slate-500 flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-blue-500 text-sm"></i>
                <span>Data tersimpan secara otomatis di Database Dashboard</span>
            </div>
            
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <a href="{{ route('data.index') }}" class="w-1/2 sm:w-auto px-5 py-3 rounded-2xl border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-50 text-center transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-table"></i> Dashboard
                </a>
                <button type="submit" class="w-1/2 sm:w-auto px-8 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm shadow-lg shadow-blue-500/25 hover:from-blue-700 hover:to-indigo-700 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-calculator"></i> Hitung & Simpan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Bangun Datar Dynamic Handler
    document.getElementById('flatShape').addEventListener('change', function() {
        const shape = this.value;
        const container = document.getElementById('flatDimensions');
        const infoCard = document.getElementById('flatFormulaInfo');
        const infoText = document.getElementById('flatFormulaText');
        
        container.innerHTML = '';
        infoCard.classList.add('hidden');

        if (shape === 'square') {
            infoText.innerHTML = '<strong>Rumus Persegi:</strong> Luas = s × s (Sisi Kuadrat)';
            infoCard.classList.remove('hidden');
            container.innerHTML = `
                <div>
                    <label for="side" class="block text-xs font-bold text-slate-700 mb-1">Panjang Sisi (s)</label>
                    <input type="number" step="any" id="side" name="flatDimensions[side]" required placeholder="Masukkan nilai sisi..." 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            `;
        } else if (shape === 'triangle') {
            infoText.innerHTML = '<strong>Rumus Segitiga:</strong> Luas = ½ × alas × tinggi';
            infoCard.classList.remove('hidden');
            container.innerHTML = `
                <div>
                    <label for="base" class="block text-xs font-bold text-slate-700 mb-1">Panjang Alas (a)</label>
                    <input type="number" step="any" id="base" name="flatDimensions[base]" required placeholder="Masukkan nilai alas..." 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label for="height" class="block text-xs font-bold text-slate-700 mb-1">Tinggi (t)</label>
                    <input type="number" step="any" id="height" name="flatDimensions[height]" required placeholder="Masukkan tinggi..." 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            `;
        } else if (shape === 'circle') {
            infoText.innerHTML = '<strong>Rumus Lingkaran:</strong> Luas = π × r² (π ≈ 3.14159)';
            infoCard.classList.remove('hidden');
            container.innerHTML = `
                <div>
                    <label for="radius" class="block text-xs font-bold text-slate-700 mb-1">Jari-Jari (r)</label>
                    <input type="number" step="any" id="radius" name="flatDimensions[radius]" required placeholder="Masukkan nilai jari-jari..." 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            `;
        }
    });

    // Bangun Ruang Dynamic Handler
    document.getElementById('solidShape').addEventListener('change', function() {
        const shape = this.value;
        const container = document.getElementById('solidDimensions');
        const infoCard = document.getElementById('solidFormulaInfo');
        const infoText = document.getElementById('solidFormulaText');
        
        container.innerHTML = '';
        infoCard.classList.add('hidden');

        if (shape === 'cube') {
            infoText.innerHTML = '<strong>Rumus Kubus:</strong> Volume = s × s × s (s³)';
            infoCard.classList.remove('hidden');
            container.innerHTML = `
                <div>
                    <label for="side" class="block text-xs font-bold text-slate-700 mb-1">Panjang Sisi (s)</label>
                    <input type="number" step="any" id="side" name="solidDimensions[side]" required placeholder="Masukkan nilai sisi..." 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            `;
        } else if (shape === 'pyramid') {
            infoText.innerHTML = '<strong>Rumus Limas:</strong> Volume = ⅓ × Luas Alas × Tinggi';
            infoCard.classList.remove('hidden');
            container.innerHTML = `
                <div>
                    <label for="base_area" class="block text-xs font-bold text-slate-700 mb-1">Luas Alas (La)</label>
                    <input type="number" step="any" id="base_area" name="solidDimensions[base_area]" required placeholder="Masukkan luas alas..." 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label for="height" class="block text-xs font-bold text-slate-700 mb-1">Tinggi (t)</label>
                    <input type="number" step="any" id="height" name="solidDimensions[height]" required placeholder="Masukkan tinggi limas..." 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            `;
        } else if (shape === 'cylinder') {
            infoText.innerHTML = '<strong>Rumus Tabung:</strong> Volume = π × r² × t';
            infoCard.classList.remove('hidden');
            container.innerHTML = `
                <div>
                    <label for="radius" class="block text-xs font-bold text-slate-700 mb-1">Jari-Jari Alas (r)</label>
                    <input type="number" step="any" id="radius" name="solidDimensions[radius]" required placeholder="Masukkan jari-jari..." 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label for="height" class="block text-xs font-bold text-slate-700 mb-1">Tinggi Tabung (t)</label>
                    <input type="number" step="any" id="height" name="solidDimensions[height]" required placeholder="Masukkan tinggi tabung..." 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            `;
        }
    });
</script>
@endpush
