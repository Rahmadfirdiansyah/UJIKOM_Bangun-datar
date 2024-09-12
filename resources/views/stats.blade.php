<!DOCTYPE html>
<html>

<head>
    <title>Statistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header>
            <h1>Statistics</h1>
        </header>
        <div>
            <h2>Total Penghitungan</h2>
            <p>{{ $totalCalculations }}</p>

            <h2>Persentase Penghitungan per Bangun</h2>
            <ul>
                @foreach ($shapePercentages as $shape => $percentage)
                    <li>{{ ucfirst($shape) }}: {{ $percentage }}%</li>
                @endforeach
            </ul>
        </div>
    </div>
</body>

</html>
