<?php
include('../../config/koneksi.php');

$id = $_GET['id'];

// Gunakan transaksi untuk memastikan kedua operasi berhasil atau gagal bersama-sama
mysqli_begin_transaction($connect);

$error = false;

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
