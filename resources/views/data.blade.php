<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("data-table");
            switching = true;
            dir = "asc"; // Set the sorting direction to ascending initially

            while (switching) {
                switching = false;
                rows = table.rows;

                // Loop through all table rows (except the headers)
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;

                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];

                    // If sorting column is the age column (index 3), sort numerically
                    if (n === 3) {
                        if (dir === "asc") {
                            if (parseInt(x.innerHTML) > parseInt(y.innerHTML)) {
                                shouldSwitch = true;
                                break;
                            }
                        } else if (dir === "desc") {
                            if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
                                shouldSwitch = true;
                                break;
                            }
                        }
                    } else {
                        // Sort alphabetically for other columns
                        if (dir === "asc") {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                break;
                            }
                        } else if (dir === "desc") {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                }

                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    // If no switching has been done AND the direction is "asc", set the direction to "desc" and run the loop again.
                    if (switchcount === 0 && dir === "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-center">Dashboard</h1>
        </header>
        <table id="data-table" class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
            <thead>
                <tr class="bg-gray-200 text-left text-sm font-semibold text-gray-700">
                    <th class="p-4 cursor-pointer" onclick="sortTable(0)">Tanggal</th>
                    <th class="p-4 cursor-pointer" onclick="sortTable(1)">Nama</th>
                    <th class="p-4 cursor-pointer" onclick="sortTable(2)">Sekolah</th>
                    <th class="p-4 cursor-pointer" onclick="sortTable(3)">Usia</th>
                    <th class="p-4 cursor-pointer" onclick="sortTable(4)">Alamat</th>
                    <th class="p-4 cursor-pointer" onclick="sortTable(5)">Telepon</th>
                    <th class="p-4 cursor-pointer" onclick="sortTable(6)">Hasil</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($calculations as $calculation)
                    <tr class="border-t border-gray-200">
                        <td class="p-4">
                            @if ($calculation->created_at)
                                {{ $calculation->created_at->format('Y-m-d H:i:s') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="p-4">{{ $calculation->name }}</td>
                        <td class="p-4">{{ $calculation->school }}</td>
                        <td class="p-4">{{ $calculation->age }}</td>
                        <td class="p-4">{{ $calculation->address }}</td>
                        <td class="p-4">{{ $calculation->phone }}</td>
                        <td class="p-4">{{ $calculation->result }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex items-center justify-center">
        <a href="{{ url()->previous() }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
            <buttont type="button" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded" onclick="tableToCSV()">CSV</buttont>
    </div>

    <script type="text/javascript">
        function tableToCSV() {

            // Variable to store the final csv data
            let csv_data = [];

            // Get each row data
            let rows = document.getElementsByTagName('tr');
            for (let i = 0; i < rows.length; i++) {

                // Get each column data
                let cols = rows[i].querySelectorAll('td,th');

                // Stores each csv row data
                let csvrow = [];
                for (let j = 0; j < cols.length; j++) {

                    // Get the text data of each cell
                    // of a row and push it to csvrow
                    csvrow.push(cols[j].innerHTML);
                }

                // Combine each column value with comma
                csv_data.push(csvrow.join(","));
            }

            // Combine each row data with new line character
            csv_data = csv_data.join('\n');

            // Call this function to download csv file  
            downloadCSVFile(csv_data);

        }

        function downloadCSVFile(csv_data) {

            // Create CSV file object and feed
            // our csv_data into it
            CSVFile = new Blob([csv_data], {
                type: "text/csv"
            });

            // Create to temporary link to initiate
            // download process
            let temp_link = document.createElement('a');

            // Download csv file
            temp_link.download = "GfG.csv";
            let url = window.URL.createObjectURL(CSVFile);
            temp_link.href = url;

            // This link should not be displayed
            temp_link.style.display = "none";
            document.body.appendChild(temp_link);

            // Automatically click the link to
            // trigger download
            temp_link.click();
            document.body.removeChild(temp_link);
        }
    </script>
</body>

</html>
