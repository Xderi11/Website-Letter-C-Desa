<?php
session_start();
include ('../../config/koneksi.php');

if(isset($_POST['submit'])) {
    $nama_pemilik = $_POST['fnama_pemilik'] ?? '';
    $alamat_pemilik = $_POST['falamat_pemilik'] ?? '';
    $no_persil = $_POST['fno_persil'] ?? '';
    $kelas_desa = $_POST['fkelas_desa'] ?? '';
    $luas_milik = $_POST['fluas_milik'] ?? '';
    $jenis_tanah = $_POST['fjenis_tanah'] ?? '';
    $tanggal = $_POST['ftanggal'] ?? '';
    $pajak_bumi = str_replace('.', '', $_POST['fpajak_bumi']) ?? ''; // Menghapus titik sebagai pemisah ribuan
    $keterangan_tanah = $_POST['fketerangan_tanah'] ?? '';

    // Siapkan query untuk memasukkan data baru ke kepemilikan_letter_c
    $query_insert = "
        INSERT INTO kepemilikan_letter_c (nama_pemilik, alamat_pemilik, no_persil, kelas_desa, luas_milik, jenis_tanah, tanggal, pajak_bumi, keterangan_tanah)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";

    $stmt_insert = $connect->prepare($query_insert);
    $stmt_insert->bind_param("sssssssss", $nama_pemilik, $alamat_pemilik, $no_persil, $kelas_desa, $luas_milik, $jenis_tanah, $tanggal, $pajak_bumi, $keterangan_tanah);

    if ($stmt_insert->execute()) {
        $_SESSION['success_message'] = "Data Letter C berhasil ditambahkan.";
        header("Location: ../kepemilikan/");
        exit;
    } else {
        $_SESSION['error_message'] = "Gagal menambahkan data Letter C: " . $stmt_insert->error;
        header("Location: tambah-penduduk.php");
        exit;
    }
}

mysqli_close($connect);
?>