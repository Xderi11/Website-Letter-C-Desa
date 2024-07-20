<?php
include('../../config/koneksi.php');

$id = $_GET['id'];

// Gunakan transaksi untuk memastikan semua operasi berhasil atau gagal bersama-sama
mysqli_begin_transaction($connect);

$error = false;

// Cari no_persil dari tabel kepemilikan_letter_c berdasarkan id_kepemilikan
$query_get_no_persil = "SELECT no_persil FROM kepemilikan_letter_c WHERE id_kepemilikan = ?";
$stmt_get_no_persil = $connect->prepare($query_get_no_persil);
$stmt_get_no_persil->bind_param("i", $id);
$stmt_get_no_persil->execute();
$result = $stmt_get_no_persil->get_result();
$row = $result->fetch_assoc();
$no_persil = $row['no_persil'];

// Hapus data dari tabel surat_keterangan yang berhubungan
$query_delete_surat_keterangan = "DELETE FROM surat_keterangan WHERE no_persil = ?";
$stmt_delete_surat_keterangan = $connect->prepare($query_delete_surat_keterangan);
$stmt_delete_surat_keterangan->bind_param("s", $no_persil);

if (!$stmt_delete_surat_keterangan->execute()) {
    $error = true;
}

// Hapus data dari tabel perubahan terlebih dahulu
$query_delete_perubahan = "DELETE FROM perubahan WHERE id_kepemilikan = ?";
$stmt_delete_perubahan = $connect->prepare($query_delete_perubahan);
$stmt_delete_perubahan->bind_param("i", $id);

if (!$stmt_delete_perubahan->execute()) {
    $error = true;
}

// Hapus data dari tabel pemilik
$query_delete_pemilik = "DELETE FROM pemilik WHERE id_kepemilikan = ?";
$stmt_delete_pemilik = $connect->prepare($query_delete_pemilik);
$stmt_delete_pemilik->bind_param("i", $id);

if (!$stmt_delete_pemilik->execute()) {
    $error = true;
}

// Hapus data dari tabel kepemilikan_letter_c
$query_delete_kepemilikan = "DELETE FROM kepemilikan_letter_c WHERE id_kepemilikan = ?";
$stmt_delete_kepemilikan = $connect->prepare($query_delete_kepemilikan);
$stmt_delete_kepemilikan->bind_param("i", $id);

if (!$stmt_delete_kepemilikan->execute()) {
    $error = true;
}

// Check if there were any errors
if (!$error) {
    mysqli_commit($connect);
    header('location:index.php');
    exit;
} else {
    mysqli_rollback($connect);
    header('location:index.php?pesan=gagal-menghapus');
    exit;
}

mysqli_close($connect);
?>
