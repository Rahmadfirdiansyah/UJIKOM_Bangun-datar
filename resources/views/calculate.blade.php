<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Luas dan Volume</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-4">
        <header class="mb-4">
            <h1 class="text-center">Hitung Luas dan Volume</h1>
        </header>
        <form action="{{ route('calculate.store') }}" method="POST">
            @csrf
            <h3 class="mb-3">Biodata Siswa</h3>
            <div class="mb-3">
                <label for="name" class="form-label">Nama:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="school" class="form-label">Nama Sekolah:</label>
                <input type="text" id="school" name="school" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Usia:</label>
                <input type="number" id="age" name="age" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Alamat Rumah:</label>
                <input type="text" id="address" name="address" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon:</label>
                <input type="number" id="phone" name="phone" class="form-control" required>
            </div>

            <h3 class="mb-3">Pilih Bangun Datar</h3>
            <div class="mb-3">
                <label for="flatShape" class="form-label">Jenis Bangun Datar:</label>
                <select id="flatShape" name="flatShape" class="form-select">
                    <option value="">Pilih Bangun Datar</option>
                    <option value="square">Persegi</option>
                    <option value="triangle">Segitiga</option>
                    <option value="circle">Lingkaran</option>
                </select>
            </div>

            <div id="flatDimensions" class="mb-3">
                <!-- Input dimensi bangun datar akan ditambahkan secara dinamis dengan JavaScript -->
            </div>

            <h3 class="mb-3">Pilih Bangun Ruang</h3>
            <div class="mb-3">
                <label for="solidShape" class="form-label">Jenis Bangun Ruang:</label>
                <select id="solidShape" name="solidShape" class="form-select">
                    <option value="">Pilih Bangun Ruang</option>
                    <option value="cube">Kubus</option>
                    <option value="pyramid">Limas</option>
                    <option value="cylinder">Tabung</option>
                </select>
            </div>

            <div id="solidDimensions" class="mb-3">
                <!-- Input dimensi bangun ruang akan ditambahkan secara dinamis dengan JavaScript -->
            </div>

            <button type="submit" class="btn btn-primary">Hitung</button>
            <div class="text-center mt-3">
                <a href="{{ route('stats') }}" class="btn btn-danger">Lihat Statistik</a>
            </div>
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Event listener untuk Bangun Datar
            document.getElementById('flatShape').addEventListener('change', function() {
                var shape = this.value;
                var flatDimensionsDiv = document.getElementById('flatDimensions');
                flatDimensionsDiv.innerHTML = '';

                var inputHTML = '';

                if (shape === 'square') {
                    inputHTML = `
                        <label for="side" class="form-label">Panjang Sisi (Persegi):</label>
                        <input type="number" id="side" name="flatDimensions[side]" class="form-control" required>
                    `;
                } else if (shape === 'triangle') {
                    inputHTML = `
                        <label for="base" class="form-label">Panjang Alas (Segitiga):</label>
                        <input type="number" id="base" name="flatDimensions[base]" class="form-control" required>
                        <label for="height" class="form-label">Tinggi (Segitiga):</label>
                        <input type="number" id="height" name="flatDimensions[height]" class="form-control" required>
                    `;
                } else if (shape === 'circle') {
                    inputHTML = `
                        <label for="radius" class="form-label">Jari-Jari (Lingkaran):</label>
                        <input type="number" id="radius" name="flatDimensions[radius]" class="form-control" required>
                    `;
                }

                flatDimensionsDiv.innerHTML = inputHTML;
            });

            // Event listener untuk Bangun Ruang
            document.getElementById('solidShape').addEventListener('change', function() {
                var shape = this.value;
                var solidDimensionsDiv = document.getElementById('solidDimensions');
                solidDimensionsDiv.innerHTML = '';

                var inputHTML = '';

                if (shape === 'cube') {
                    inputHTML = `
                        <label for="side" class="form-label">Panjang Sisi (Kubus):</label>
                        <input type="number" id="side" name="solidDimensions[side]" class="form-control" required>
                    `;
                } else if (shape === 'pyramid') {
                    inputHTML = `
                        <label for="base_area" class="form-label">Luas Alas (Limas):</label>
                        <input type="number" id="base_area" name="solidDimensions[base_area]" class="form-control" required>
                        <label for="height" class="form-label">Tinggi (Limas):</label>
                        <input type="number" id="height" name="solidDimensions[height]" class="form-control" required>
                    `;
                } else if (shape === 'cylinder') {
                    inputHTML = `
                        <label for="radius" class="form-label">Jari-Jari (Tabung):</label>
                        <input type="number" id="radius" name="solidDimensions[radius]" class="form-control" required>
                        <label for="height" class="form-label">Tinggi (Tabung):</label>
                        <input type="number" id="height" name="solidDimensions[height]" class="form-control" required>
                    `;
                }

                solidDimensionsDiv.innerHTML = inputHTML;
            });
        </script>
    </div>
</body>

</html>
