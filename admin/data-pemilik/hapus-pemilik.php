<?php
include ('../../config/koneksi.php');

if (isset($_GET['id'])) {
    $id_identitas = $_GET['id'];

    // Mengambil data nik dari tabel identitas berdasarkan id_identitas
    $query = "SELECT nik FROM identitas WHERE id_identitas='$id_identitas'";
    $result = mysqli_query($connect, $query);
    $data = mysqli_fetch_assoc($result);
    $nik = $data['nik'];

    // Menghapus data dari tabel tanah yang terkait dengan nik
    // $qHapusTanah = "DELETE FROM tanah WHERE nik='$nik'";
    // $hapusTanah = mysqli_query($connect, $qHapusTanah);

    // Menghapus data dari tabel identitas
    $qHapusPemilik = "DELETE FROM identitas WHERE id_identitas='$id_identitas'";
    $hapusPemilik = mysqli_query($connect, $qHapusPemilik);

    if ($hapusPemilik) {
        header("location:index.php?pesan=berhasil-menghapus");
    } else {
        echo ("<script LANGUAGE='JavaScript'>window.alert('Gagal menghapus data pemilik'); window.location.href='index.php';</script>");
    }
} else {
    header("location:index.php?pesan=gagal-menghapus");
}
?>
