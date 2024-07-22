<?php
// Koneksi ke database
include('../../config/koneksi.php');

// Inisialisasi variabel data untuk menghindari undefined variable error
$pemilik_data = [];
$perubahan_data = [];
$nik = "";
$nama_pemilik = "";
$alamat_pemilik = "";
$no_persil = "";
$tanggal_penerbitan = "";
$tanggal_perubahan = "";
$sebab_perubahan = "";
$status_kepemilikan = "";

// Periksa apakah ada parameter nik yang dikirimkan melalui URL
if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];

    // Query untuk mengambil data pemilik berdasarkan NIK dari tabel pemilik
    $query_pemilik = "SELECT nik, nama_pemilik, alamat_pemilik, no_persil, tanggal, tanggal_perubahan, sebab_perubahan, status_kepemilikan 
                      FROM pemilik 
                      WHERE nik = '$nik'";
    
    $result_pemilik = mysqli_query($connect, $query_pemilik);
    if ($result_pemilik && mysqli_num_rows($result_pemilik) > 0) {
        $pemilik_data = mysqli_fetch_all($result_pemilik, MYSQLI_ASSOC);
        
        // Ambil data pemilik pertama sebagai referensi untuk nama dan alamat pemilik
        $pemilik_info = $pemilik_data[0];
        $nama_pemilik = $pemilik_info['nama_pemilik'];
        $alamat_pemilik = $pemilik_info['alamat_pemilik'];
    }

    // Query untuk mengambil data perubahan berdasarkan NIK dari tabel perubahan
    $query_perubahan = "SELECT nik, nama_pemilik, alamat_pemilik, no_persil, tanggal, tanggal_perubahan, sebab_perubahan, status_kepemilikan 
                        FROM perubahan 
                        WHERE nik = '$nik' AND status_kepemilikan IS NOT NULL AND status_kepemilikan != ''";
    
    $result_perubahan = mysqli_query($connect, $query_perubahan);
    if ($result_perubahan && mysqli_num_rows($result_perubahan) > 0) {
        $perubahan_data = mysqli_fetch_all($result_perubahan, MYSQLI_ASSOC);
        
        // Perbarui nama dan alamat pemilik dari data perubahan jika ada
        $perubahan_info = $perubahan_data[0];
        $nama_pemilik = $perubahan_info['nama_pemilik'];
        $alamat_pemilik = $perubahan_info['alamat_pemilik'];
    }
} else {
    echo "<div class='alert alert-danger'><center>Parameter NIK tidak valid.</center></div>";
    exit;
}

// Tutup koneksi database
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Kepemilikan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f2f2f2;
            margin: 20px;
        }
        .header, .sub-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin-bottom: 5px;
        }
        .bold-uppercase {
            font-weight: bold;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .note {
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .footer button:hover {
            background-color: #0056b3;
        }
        .sub-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .garis {
            border-top: 1px double #000;
            border-bottom: 3px double #000;
            width: 100%;
            margin-top: 10px;
        }

        .info-label1 {
            width: 100px;
            display: inline-block;
            vertical-align: top;
            text-align: right;
            margin-right: 20px;
        }
        .info-label2 {
            width: 27px;
            display: inline-block;
            vertical-align: top;
            text-align: right;
            margin-right: 20px;
        }
        .info-label3 {
            width: 22px;
            display: inline-block;
            vertical-align: top;
            text-align: right;
            margin-right: 20px;
        }
        .info-value {
            display: inline-block;
            vertical-align: top;
        }
        .info-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
    </style>

    <script>
        // Otomatis menjalankan fungsi cetak saat halaman dimuat
        window.onload = function() {
            window.print();
        };
    </script>
</head>
<body>

<div class="header">
    <h1>LAPORAN KEPEMILIKAN TANAH</h1>
</div>

<div class="sub-header">
    <h3>DESA TANJUNG BERLIAN BARAT KECAMATAN KUNDUR UTARA KABUPATEN KARIMUN</h3>
    <div class="garis"></div>
</div>

<div class="info-container">
    <p><span>NIK<span class="info-label1">:</span></span> <span class="info-value bold-uppercase"><?php echo $nik; ?></span></p>
    <p><span>Nama Pemilik<span class="info-label2">:</span></span> <span class="info-value bold-uppercase"><?php echo $nama_pemilik; ?></span></p>
    <p><span>Alamat Pemilik<span class="info-label3">:</span></span> <span class="info-value bold-uppercase"><?php echo $alamat_pemilik; ?></span></p>
</div>

<!-- Tabel Kepemilikan Tanah -->
<p><span class="bold-uppercase">Kepemilikan Tanah</span></p>
<table>
    <thead>
        <tr>
            <th>Nomor Persil</th>
            <th>Tanggal Penerbitan</th>
            <th>Tanggal Perubahan</th>
            <th>Sebab Perubahan</th>
            <th>Status Kepemilikan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($pemilik_data)) {
            foreach ($pemilik_data as $row) {
                echo "<tr>";
                echo "<td>" . strtoupper($row['no_persil']) . "</td>";
                echo "<td>" . strtoupper($row['tanggal']) . "</td>";
                echo "<td>" . strtoupper($row['tanggal_perubahan']) . "</td>";
                echo "<td>" . strtoupper($row['sebab_perubahan']) . "</td>";
                echo "<td>" . strtoupper($row['status_kepemilikan']) . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>

<!-- Tabel Riwayat Kepemilikan -->
<p><span class="bold-uppercase">Riwayat Kepemilikan</span></p>
<table>
    <thead>
        <tr>
            <th>Nomor Persil</th>
            <th>Tanggal Penerbitan</th>
            <th>Tanggal Perubahan</th>
            <th>Sebab Perubahan</th>
            <th>Status Kepemilikan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($perubahan_data)) {
            foreach ($perubahan_data as $row) {
                echo "<tr>";
                echo "<td>" . strtoupper($row['no_persil']) . "</td>";
                echo "<td>" . strtoupper($row['tanggal']) . "</td>";
                echo "<td>" . strtoupper($row['tanggal_perubahan']) . "</td>";
                echo "<td>" . strtoupper($row['sebab_perubahan']) . "</td>";
                echo "<td>" . strtoupper($row['status_kepemilikan']) . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>

</body>
</html>
