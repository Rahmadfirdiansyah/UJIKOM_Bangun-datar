@extends('layouts.app')

@section('title', 'Data Dashboard Perhitungan')

@section('content')
<div class="space-y-6">
    <!-- Header Title & Action Buttons -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard Perhitungan</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar riwayat seluruh kalkulasi bangun datar dan bangun ruang siswa</p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="exportTableToCSV('data-perhitungan.csv')" 
                    class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                <i class="fa-solid fa-file-csv text-base"></i> Export CSV
            </button>
            <a href="{{ route('calculate.index') }}" 
               class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Hitung Baru
            </a>
        </div>
    </div>

    <!-- Metrics Overview Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Data</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ count($calculations) }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                <i class="fa-solid fa-database text-lg"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sekolah</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $calculations->pluck('school')->unique()->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                <i class="fa-solid fa-school text-lg"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Bangun Datar</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $calculations->whereNotNull('bangun_datar')->where('bangun_datar', '!=', '')->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                <i class="fa-solid fa-vector-square text-lg"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Bangun Ruang</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $calculations->whereNotNull('bangun_ruang')->where('bangun_ruang', '!=', '')->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                <i class="fa-solid fa-cube text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden space-y-4 p-6">
        <!-- Live Search Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 border-b border-slate-100 pb-4">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari nama, sekolah, atau hasil..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition">
            </div>
            <p class="text-xs text-slate-400">Klik judul kolom tabel untuk mengurutkan (Sort)</p>
        </div>

        <div class="overflow-x-auto">
            <table id="data-table" class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider font-bold border-b border-slate-200">
                        <th class="p-4 cursor-pointer hover:bg-slate-100 transition" onclick="sortTable(0)">
                            Tanggal <i class="fa-solid fa-sort text-slate-400 text-xs ml-1"></i>
                        </th>
                        <th class="p-4 cursor-pointer hover:bg-slate-100 transition" onclick="sortTable(1)">
                            Nama <i class="fa-solid fa-sort text-slate-400 text-xs ml-1"></i>
                        </th>
                        <th class="p-4 cursor-pointer hover:bg-slate-100 transition" onclick="sortTable(2)">
                            Sekolah <i class="fa-solid fa-sort text-slate-400 text-xs ml-1"></i>
                        </th>
                        <th class="p-4 cursor-pointer hover:bg-slate-100 transition" onclick="sortTable(3)">
                            Usia <i class="fa-solid fa-sort text-slate-400 text-xs ml-1"></i>
                        </th>
                        <th class="p-4 cursor-pointer hover:bg-slate-100 transition" onclick="sortTable(4)">
                            Alamat <i class="fa-solid fa-sort text-slate-400 text-xs ml-1"></i>
                        </th>
                        <th class="p-4 cursor-pointer hover:bg-slate-100 transition" onclick="sortTable(5)">
                            Telepon <i class="fa-solid fa-sort text-slate-400 text-xs ml-1"></i>
                        </th>
                        <th class="p-4 cursor-pointer hover:bg-slate-100 transition" onclick="sortTable(6)">
                            Bangun Datar <i class="fa-solid fa-sort text-slate-400 text-xs ml-1"></i>
                        </th>
                        <th class="p-4 cursor-pointer hover:bg-slate-100 transition" onclick="sortTable(7)">
                            Bangun Ruang <i class="fa-solid fa-sort text-slate-400 text-xs ml-1"></i>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse ($calculations as $calculation)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Tanggal -->
                            <td class="p-4 whitespace-nowrap text-slate-500">
                                {{ $calculation->created_at ? $calculation->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <!-- Nama -->
                            <td class="p-4 font-bold text-slate-900 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($calculation->name, 0, 1) }}
                                    </div>
                                    <span>{{ $calculation->name }}</span>
                                </div>
                            </td>
                            <!-- Sekolah -->
                            <td class="p-4 whitespace-nowrap">{{ $calculation->school }}</td>
                            <!-- Usia -->
                            <td class="p-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg font-bold">
                                    {{ $calculation->age }} th
                                </span>
                            </td>
                            <!-- Alamat -->
                            <td class="p-4 max-w-xs truncate" title="{{ $calculation->address }}">{{ $calculation->address }}</td>
                            <!-- Telepon -->
                            <td class="p-4 whitespace-nowrap text-slate-500">{{ $calculation->phone }}</td>
                            <!-- Bangun Datar -->
                            <td class="p-4">
                                @if ($calculation->bangun_datar)
                                    <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl font-semibold">
                                        {{ $calculation->bangun_datar }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">-</span>
                                @endif
                            </td>
                            <!-- Bangun Ruang -->
                            <td class="p-4">
                                @if ($calculation->bangun_ruang)
                                    <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-xl font-semibold">
                                        {{ $calculation->bangun_ruang }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-4xl mb-3 block text-slate-300"></i>
                                Belum ada data perhitungan. Silakan tambah data baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Real-time table filter
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const table = document.getElementById("data-table");
        const tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let visible = false;
            const td = tr[i].getElementsByTagName("td");
            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    const txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        visible = true;
                        break;
                    }
                }
            }
            tr[i].style.display = visible ? "" : "none";
        }
    }

    // Table sorting function
    function sortTable(n) {
        let table = document.getElementById("data-table");
        let rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        switching = true;
        dir = "asc";

        while (switching) {
            switching = false;
            rows = table.rows;

            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];

                let xVal = x.textContent || x.innerText;
                let yVal = y.textContent || y.innerText;

                if (n === 3) {
                    let xNum = parseInt(xVal) || 0;
                    let yNum = parseInt(yVal) || 0;
                    if (dir === "asc") {
                        if (xNum > yNum) { shouldSwitch = true; break; }
                    } else if (dir === "desc") {
                        if (xNum < yNum) { shouldSwitch = true; break; }
                    }
                } else {
                    if (dir === "asc") {
                        if (xVal.toLowerCase() > yVal.toLowerCase()) { shouldSwitch = true; break; }
                    } else if (dir === "desc") {
                        if (xVal.toLowerCase() < yVal.toLowerCase()) { shouldSwitch = true; break; }
                    }
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount === 0 && dir === "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }

    // Clean CSV Export Function
    function exportTableToCSV(filename) {
        let csv = [];
        let rows = document.querySelectorAll("#data-table tr");
        
        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");
            for (let j = 0; j < cols.length; j++) {
                let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").replace(/\s+/g, " ").trim();
                data = data.replace(/"/g, '""');
                row.push('"' + data + '"');
            }
            csv.push(row.join(","));
        }

        let csvFile = new Blob([csv.join("\n")], { type: "text/csv;charset=utf-8;" });
        let downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>
@endpush
