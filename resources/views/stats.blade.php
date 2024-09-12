<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Perhitungan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container my-4">
        <h2 class="text-center mb-4">Statistik Perhitungan</h2>

        <div class="mb-4">
            <p><strong>Total Penghitungan:</strong> {{ $totalCalculations }}</p>
        </div>

        <div class="mb-4">
            <h3>Persentase Bangun Datar</h3>
            <p>{{ $flatPercentage }}%</p>
        </div>

        <div class="mb-4">
            <h3>Persentase Bangun Ruang</h3>
            <p>{{ $solidPercentage }}%</p>
        </div>

        <div class="mb-4">
            <h3>Detail Persentase Masing-Masing Bentuk</h3>
            <ul>
                @foreach ($shapePercentages as $shape => $percentage)
                    <li>{{ ucfirst($shape) }}: {{ number_format($percentage, 2) }}%</li>
                @endforeach
            </ul>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('calculate.index') }}" class="btn btn-danger">Kembali ke Halaman Perhitungan</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-+bZ4R1vV1HTnG3J3C5S3jOTyFVU4vjZ4zPR69rAkzS4JJZq8VqVVyea93sR0LXDO" crossorigin="anonymous">
    </script>
</body>

</html>
