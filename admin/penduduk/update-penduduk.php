<?php
include ('../../config/koneksi.php');

if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nama_pemilik = $_POST['fnama_pemilik'];
    $alamat_pemilik = addslashes($_POST['falamat_pemilik']);
    $tanggal = $_POST['ftanggal'];

    $qUpdate = "UPDATE kepemilikan_letter_c SET nama_pemilik = '$nama_pemilik', alamat_pemilik = '$alamat_pemilik', tanggal = '$tanggal' WHERE id_kepemilikan='$id'";
    $update = mysqli_query($connect, $qUpdate);

    if($update){
        header('location: ../penduduk/');
        exit; // Penting untuk menghentikan eksekusi skrip setelah mengarahkan pengguna
    } else {
        echo "<script>alert('Gagal mengubah data Letter C'); window.location.href='../penduduk/';</script>";
    }
}
?>
