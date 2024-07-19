<?php
// Koneksi ke database
include('../../config/koneksi.php');

// Inisialisasi variabel data untuk menghindari undefined variable error
$data = [];
$nama_pemilik = "";
$alamat_pemilik = "";
$jenis_tanah = "";

// Periksa apakah ada data yang dikirimkan melalui POST
if (isset($_POST['no_persil'])) {
    $no_persil = $_POST['no_persil'];

    // Query untuk mengambil data pemilik berdasarkan nomor persil dari tabel pemilik
    $query_pemilik = "SELECT nama_pemilik, alamat_pemilik FROM pemilik WHERE no_persil = '$no_persil' LIMIT 1";
    $result_pemilik = mysqli_query($connect, $query_pemilik);

    if ($result_pemilik && mysqli_num_rows($result_pemilik) > 0) {
        $row_pemilik = mysqli_fetch_assoc($result_pemilik);
        $nama_pemilik = strtoupper($row_pemilik['nama_pemilik']);
        $alamat_pemilik = strtoupper($row_pemilik['alamat_pemilik']);
    } else {
        echo "<div class='alert alert-danger'><center>Data pemilik tidak ditemukan untuk nomor persil tersebut.</center></div>";
    }

    // Query untuk mengambil data perubahan berdasarkan nomor persil dan status kepemilikan "Tidak Aktif"
    $query_detail = "
        SELECT pu.no_persil, t.jenis_tanah, pu.kelas_desa, pu.luas_milik, pu.pajak_bumi, pu.sebab_perubahan, pu.tanggal_perubahan 
        FROM perubahan pu
        LEFT JOIN tanah t ON pu.no_persil = t.no_persil
        WHERE pu.no_persil = '$no_persil' AND pu.status_kepemilikan = 'Tidak Aktif'
    ";
    $result_detail = mysqli_query($connect, $query_detail);

    if ($result_detail && mysqli_num_rows($result_detail) > 0) {
        // Ambil data jika ditemukan
        $data = mysqli_fetch_all($result_detail, MYSQLI_ASSOC);
    } else {
        echo "<div class='alert alert-danger'><center>Data perubahan tidak ditemukan untuk nomor persil tersebut.</center></div>";
    }
} else {
    echo "<div class='alert alert-danger'><center>Tidak ada nomor persil yang dikirimkan.</center></div>";
}

// Tutup koneksi database
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Letter C Desa - Cetak</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000; /* Mengubah warna garis menjadi hitam */
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
            border-top: 1px double #000; /* Garis tipis di atas */
            border-bottom: 3px double #000; /* Garis tebal di bawah */
            width: 100%;
            margin-top: 10px; /* Jarak antara teks dan garis */
        }

        /* Gaya untuk label agar titik dua sejajar */
        .info-label {
            width: 23px; /* Sesuaikan lebar ini agar sesuai dengan label terpanjang */
            display: inline-block;
            vertical-align: top;
            text-align: right;
            margin-right: 20px;
        }
        .info-label2 {
            width: 130px; /* Sesuaikan lebar ini agar sesuai dengan label terpanjang */
            display: inline-block;
            vertical-align: top;
            text-align: right;
            margin-right: 20px;
        }

        /* Gaya untuk nilai */
        .info-value {
            display: inline-block;
            vertical-align: top;
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
    <h1>LETER C-DESA</h1>
</div>

<div class="sub-header">
    <h3>DESA TANJUNG BERLIAN BARAT KECAMATAN KUNDUR UTARA KABUPATEN KARIMUN</h3>
    <div class="garis"></div>
</div>

<div class="info">
    <p><span>NAMA PEMILIK TANAH<span class="info-label">:</span></span> <strong><?php echo $nama_pemilik; ?></strong></p>
    <p><span>ALAMAT<span class="info-label2">:</span></span> <strong><?php echo $alamat_pemilik; ?></strong></p>
</div>

<table class="table">
    <thead>
        <tr>
            <div class="garis"></div>
            <th colspan="5"><?php echo isset($data[0]['jenis_tanah']) ? strtoupper($data[0]['jenis_tanah']) : ''; ?></th>
        </tr>
        <tr>
            <th>Nomor Persil/Blok</th>
            <th>Kelas Desa</th>
            <th>Luas Milik</th>
            <th>Pajak Bumi</th>
            <th>Sebab dan Tanggal Perubahan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Menampilkan data perubahan jika ada
        if (isset($data) && count($data) > 0) {
            foreach ($data as $row) {
                // Mengubah format tanggal
                $tanggal_perubahan = date('d-m-Y', strtotime($row['tanggal_perubahan']));
                
                echo "<tr>";
                echo "<td>" . strtoupper($row['no_persil']) . "</td>";
                echo "<td>" . strtoupper($row['kelas_desa']) . "</td>";
                echo "<td>" . strtoupper($row['luas_milik']) . "</td>";
                echo "<td>" . 'Rp. ' . number_format($row['pajak_bumi'], 0, ',', '.') . "</td>";
                echo "<td>" . strtoupper($row['sebab_perubahan'] . ' - ' . $tanggal_perubahan) . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>

</body>
</html>
