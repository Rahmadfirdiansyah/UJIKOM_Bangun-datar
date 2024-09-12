<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Luas dan Volume</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                <input type="text" id="phone" name="phone" class="form-control" required>
            </div>
            <h3 class="mb-3">Pilih Bangun</h3>
            <div class="mb-3">
                <label for="shape" class="form-label">Jenis Bangun:</label>
                <select id="shape" name="shape" class="form-select">
                    <option value="square">Persegi</option>
                    <option value="triangle">Segitiga</option>
                    <option value="circle">Lingkaran</option>
                    <option value="cube">Kubus</option>
                    <option value="pyramid">Limas</option>
                    <option value="cylinder">Tabung</option>
                </select>
            </div>
            <div id="dimensions" class="mb-3">
                <!-- Input dimensi akan ditambahkan secara dinamis dengan JavaScript -->
            </div>
            <button type="submit" class="btn btn-primary">Hitung</button>
        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-+bZ4R1vV1HTnG3J3C5S3jOTyFVU4vjZ4zPR69rAkzS4JJZq8VqVVyea93sR0LXDO" crossorigin="anonymous">
        </script>
        <script>
            document.getElementById('shape').addEventListener('change', function() {
                var shape = this.value;
                var dimensionsDiv = document.getElementById('dimensions');
                dimensionsDiv.innerHTML = '';

                var inputHTML = '';

                if (shape === 'square' || shape === 'cube') {
                    inputHTML = `
                        <label for="side" class="form-label">Panjang Sisi:</label>
                        <input type="number" id="side" name="dimensions[side]" class="form-control" required>
                    `;
                } else if (shape === 'triangle') {
                    inputHTML = `
                        <label for="base" class="form-label">Panjang Alas:</label>
                        <input type="number" id="base" name="dimensions[base]" class="form-control" required>
                        <label for="height" class="form-label">Tinggi:</label>
                        <input type="number" id="height" name="dimensions[height]" class="form-control" required>
                    `;
                } else if (shape === 'circle' || shape === 'cylinder') {
                    inputHTML = `
                        <label for="radius" class="form-label">Jari-Jari:</label>
                        <input type="number" id="radius" name="dimensions[radius]" class="form-control" required>
                        <label for="height" class="form-label">Tinggi:</label>
                        <input type="number" id="height" name="dimensions[height]" class="form-control" required>
                    `;
                } else if (shape === 'pyramid') {
                    inputHTML = `
                        <label for="base_area" class="form-label">Luas Alas:</label>
                        <input type="number" id="base_area" name="dimensions[base_area]" class="form-control" required>
                        <label for="height" class="form-label">Tinggi:</label>
                        <input type="number" id="height" name="dimensions[height]" class="form-control" required>
                    `;
                }

                dimensionsDiv.innerHTML = inputHTML;
            });
        </script>
    </div>
</body>

</html>
