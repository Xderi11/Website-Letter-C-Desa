<?php
include ('../../config/koneksi.php');

if (isset($_POST['submit'])) {
    $nik = $_POST['fnik'];
    $nama_pemilik = $_POST['fnama_pemilik'];
    $alamat_pemilik = $_POST['falamat_pemilik'];

    // Cek apakah NIK sudah ada di tabel identitas
    $qCekNik = mysqli_query($connect, "SELECT * FROM identitas WHERE nik='$nik'");
    $row = mysqli_num_rows($qCekNik);

    if ($row > 0) {
        header('location:index.php?pesan=gagal-menambah');
    } else {
        // Menambahkan data pemilik ke tabel identitas
        $qTambahPemilik = "INSERT INTO identitas (nik, nama_pemilik, alamat_pemilik) 
                           VALUES ('$nik', '$nama_pemilik', '$alamat_pemilik')";
        $tambahPemilik = mysqli_query($connect, $qTambahPemilik);

        if ($tambahPemilik) {
            header("location:index.php?pesan=berhasil-menambah");
        } else {
            echo ("<script LANGUAGE='JavaScript'>window.alert('Gagal menambah data pemilik'); window.location.href='index.php';</script>");
        }
    }
}
?>
