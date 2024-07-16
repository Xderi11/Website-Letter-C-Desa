<?php
session_start();
include('../../config/koneksi.php');

// Pastikan form telah disubmit
if(isset($_POST['submit'])) {
    $nama_pemilik = $_POST['fnama_pemilik'];
    $alamat_pemilik = $_POST['falamat_pemilik'];
    $no_persil = $_POST['fno_persil'];
    $kelas_desa = $_POST['fkelas_desa'];
    $luas_milik = $_POST['fluas_milik'];
    $jenis_tanah = $_POST['fjenis_tanah'];
    $tanggal = $_POST['ftanggal'];
    $pajak_bumi = str_replace('.', '', $_POST['fpajak_bumi']); // Menghapus titik sebagai pemisah ribuan
    $keterangan_tanah = $_POST['fketerangan_tanah'];

    // Cek apakah no persil sudah ada di data tanah
    $query_check_tanah = "SELECT * FROM tanah WHERE no_persil = '$no_persil'";
    $result_check_tanah = mysqli_query($connect, $query_check_tanah);

    // Cek apakah no persil sudah ada di data kepemilikan_letter_c
    $query_check_letter_c = "SELECT * FROM kepemilikan_letter_c WHERE no_persil = '$no_persil'";
    $result_check_letter_c = mysqli_query($connect, $query_check_letter_c);

    if (mysqli_num_rows($result_check_tanah) > 0 || mysqli_num_rows($result_check_letter_c) > 0) {
        // Nomor persil sudah ada, tampilkan pesan error dan redirect kembali ke form
        $_SESSION['error_message'] = "Nomor persil '$no_persil' sudah ada dalam database.";
    } else {
        // Nomor persil belum ada, lanjutkan proses penyimpanan ke kepemilikan_letter_c
        // Siapkan query untuk memasukkan data baru ke kepemilikan_letter_c
        $query_insert = "
            INSERT INTO kepemilikan_letter_c (nama_pemilik, alamat_pemilik, no_persil, kelas_desa, luas_milik, jenis_tanah, tanggal, pajak_bumi, keterangan_tanah)
            VALUES ('$nama_pemilik', '$alamat_pemilik', '$no_persil', '$kelas_desa', '$luas_milik', '$jenis_tanah', '$tanggal', '$pajak_bumi', '$keterangan_tanah')
        ";

        // Eksekusi query untuk memasukkan data
        $result_insert = mysqli_query($connect, $query_insert);

        if ($result_insert) {
            $_SESSION['success_message'] = "Data Letter C berhasil ditambahkan.";
        } else {
            $_SESSION['error_message'] = "Gagal menambahkan data Letter C: " . mysqli_error($connect); // Debug error MySQL
        }
    }
} else {
    $_SESSION['error_message'] = "Form submission tidak valid.";
}

mysqli_close($connect);
header("Location: tambah-penduduk.php");
exit;
?>