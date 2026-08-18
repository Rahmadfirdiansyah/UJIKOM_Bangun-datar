<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kalkulator Bangun Datar & Ruang') - UJIKOM</title>
    
    <!-- Google Fonts & Tailwind CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col text-slate-800 antialiased">
    <!-- Navbar Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Brand Title -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20">
                        <i class="fa-solid fa-shapes text-lg"></i>
                    </div>
                    <div>
                        <a href="{{ route('calculate.index') }}" class="font-extrabold text-lg text-slate-900 tracking-tight flex items-center gap-2">
                            GeoCalc <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-bold">UJIKOM</span>
                        </a>
                        <p class="text-xs text-slate-500 hidden sm:block">Kalkulator Bangun Datar & Bangun Ruang</p>
                    </div>
                </div>

                <!-- Desktop Navigation Menu -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('calculate.index') }}" 
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition-all flex items-center gap-2 {{ request()->routeIs('calculate.index') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-calculator text-base"></i>
                        Form Perhitungan
                    </a>
                    <a href="{{ route('data.index') }}" 
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition-all flex items-center gap-2 {{ request()->routeIs('data.index') || request()->routeIs('data.sort') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-table-cells text-base"></i>
                        Data Dashboard
                    </a>
                    <a href="{{ route('stats.index') }}" 
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition-all flex items-center gap-2 {{ request()->routeIs('stats.index') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-chart-pie text-base"></i>
                        Statistik
                    </a>
                </nav>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button type="button" id="mobile-menu-button" class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div class="hidden md:hidden border-t border-slate-200 bg-white px-4 pt-2 pb-4 space-y-1 shadow-lg" id="mobile-menu">
            <a href="{{ route('calculate.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('calculate.index') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-100' }}">
                <i class="fa-solid fa-calculator mr-2"></i> Form Perhitungan
            </a>
            <a href="{{ route('data.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('data.index') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-100' }}">
                <i class="fa-solid fa-table-cells mr-2"></i> Data Dashboard
            </a>
            <a href="{{ route('stats.index') }}" class="block px-3 py-2 rounded-lg text-base font-semibold {{ request()->routeIs('stats.index') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-100' }}">
                <i class="fa-solid fa-chart-pie mr-2"></i> Statistik
            </a>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Berhasil!</p>
                        <p class="text-xs text-emerald-700">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} GeoCalc UJIKOM - Aplikasi Perhitungan Bangun Datar & Bangun Ruang</p>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
