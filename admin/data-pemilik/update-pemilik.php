<?php
include ('../../config/koneksi.php');

if (isset($_POST['submit'])) {
    $id_identitas = $_POST['id_identitas'];
    $nik = $_POST['fnik'];
    $nama_pemilik = $_POST['fnama_pemilik'];
    $alamat_pemilik = $_POST['falamat_pemilik'];

    $qUpdatePemilik = "UPDATE identitas SET nik='$nik', nama_pemilik='$nama_pemilik', alamat_pemilik='$alamat_pemilik' WHERE id_identitas='$id_identitas'";
    $updatePemilik = mysqli_query($connect, $qUpdatePemilik);

    if ($updatePemilik) {
        header("location:index.php?pesan=berhasil-mengedit");
    } else {
        echo ("<script LANGUAGE='JavaScript'>window.alert('Gagal mengedit data pemilik'); window.location.href='index.php';</script>");
    }
} else {
    header("location:index.php?pesan=gagal-mengedit");
}
?>
