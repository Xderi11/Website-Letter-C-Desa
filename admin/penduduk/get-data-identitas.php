<?php
// Include database connection
include('../../config/koneksi.php');

if (isset($_POST['nik'])) {
    $nik = $connect->real_escape_string($_POST['nik']);

    $query = "SELECT nama_pemilik, alamat_pemilik FROM identitas WHERE nik = '$nik'";
    $result = $connect->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(array('error' => 'Data tidak ditemukan'));
    }
} else {
    echo json_encode(array('error' => 'NIK tidak diterima'));
}

$connect->close();
?>
