<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan Pesanan</title>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
        }

        .table-container {
            width: 48%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;"><b>PESANAN LAUNDRY</b></h1>
    <div class="container">
        <div class="table-container">
            <table>
                <tr>
                    <th>Nama Pelanggan</th>
                    <th>Kategori</th>
                    <th>Alamat Pengiriman</th>
                    <th>Berat (Kg)</th>
                    <th>Harga (Rp)</th>
                    <th>Foto</th>
                    <th>Last Modified</th>
                </tr>

                <?php
                $DB_NAME = "laundry";
                $DB_USER = "root";
                $DB_PASS = "";
                $DB_SERVER_LOC = "localhost";

                $conn = mysqli_connect($DB_SERVER_LOC, $DB_USER, $DB_PASS, $DB_NAME);

                $sql = "SELECT * FROM laundry";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['nama_pelanggan'] . "</td>";
                        echo "<td>" . $row['kategori'] . "</td>";
                        echo "<td>" . $row['alamat'] . "</td>";
                        echo "<td>" . $row['berat'] . "</td>";
                        echo "<td>" . $row['harga'] . "</td>";
                        echo "<td><img src='images/" . $row['foto'] . "' alt='Foto' width='120'></td>";
                        echo "<td>" . $row['tanggal_input'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Tidak ada pesanan</td></tr>";
                }

                mysqli_close($conn);
                ?>
            </table>
        </div>
        
        <div class="table-container">
            <table>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Harga (Rp)</th>
                </tr>

                <?php
                $DB_NAME = "laundry";
                $DB_USER = "root";
                $DB_PASS = "";
                $DB_SERVER_LOC = "localhost";

                $conn = mysqli_connect($DB_SERVER_LOC, $DB_USER, $DB_PASS, $DB_NAME);

                $sql = "SELECT * FROM kategori";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['kategori'] . "</td>";
                        echo "<td>" . $row['harga'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada kategori</td></tr>";
                }

                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
</body>
</html>
