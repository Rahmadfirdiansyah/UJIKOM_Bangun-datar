<!DOCTYPE html>
<html>

<head>
    <title>Data Penghitung</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header>
            <h1>Data Penghitung</h1>
        </header>
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Sekolah</th>
                    <th>Usia</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Hasil</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($calculations as $calculation)
                    <tr>
                        <td>{{ $calculation->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $calculation->name }}</td>
                        <td>{{ $calculation->school }}</td>
                        <td>{{ $calculation->age }}</td>
                        <td>{{ $calculation->address }}</td>
                        <td>{{ $calculation->phone }}</td>
                        <td>
                            {{ $calculation->shape }}:
                            <ul>
                                @foreach (json_decode($calculation->dimensions, true) as $key => $value)
                                    <li>{{ ucfirst($key) }}: {{ $value }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
