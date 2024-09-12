<!DOCTYPE html>
<html>
<head>
    <title>Statistik Penghitung</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <header>
            <h1>Statistik Penghitung</h1>
        </header>
        <?php
        $totalCalculations = \App\Models\Calculation::count();
        $shapeCounts = \App\Models\Calculation::
