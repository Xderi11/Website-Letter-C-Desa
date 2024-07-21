<?php
include ('../part/akses.php');
include ('../../config/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nik = $_POST['fnik'];
    $nama_pemilik = $_POST['fnama_pemilik'];
    $alamat_pemilik = $_POST['falamat_pemilik'];
    $no_persil = $_POST['fno_persil'];
    $kelas_desa = $_POST['fkelas_desa'];
    $luas_milik = $_POST['fluas_milik'];
    $jenis_tanah = $_POST['fjenis_tanah'];
    $pajak_bumi = $_POST['fpajak_bumi'];
    $keterangan_tanah = $_POST['fketerangan_tanah'];
    $tanggal = $_POST['ftanggal'];

    // Masukkan data ke tabel kepemilikan_letter_c
    $query1 = "INSERT INTO kepemilikan_letter_c (nik, nama_pemilik, alamat_pemilik, no_persil, kelas_desa, luas_milik, jenis_tanah, pajak_bumi, keterangan_tanah, tanggal) 
               VALUES ('$nik', '$nama_pemilik', '$alamat_pemilik', '$no_persil', '$kelas_desa', '$luas_milik', '$jenis_tanah', '$pajak_bumi', '$keterangan_tanah', '$tanggal')";
    
    if ($connect->query($query1) === TRUE) {
        // Ambil ID terakhir yang dimasukkan
        $id_kepemilikan = $connect->insert_id;

        // Masukkan data ke tabel perubahan
        $query2 = "INSERT INTO perubahan (id_kepemilikan, no_persil, nik, nama_pemilik, alamat_pemilik, kelas_desa, luas_milik, jenis_tanah, pajak_bumi, keterangan_tanah, tanggal) 
                   VALUES ('$id_kepemilikan', '$no_persil', '$nik', '$nama_pemilik', '$alamat_pemilik', '$kelas_desa', '$luas_milik', '$jenis_tanah', '$pajak_bumi', '$keterangan_tanah', '$tanggal')";

        if ($connect->query($query2) === TRUE) {
            $_SESSION['success_message'] = "Data berhasil disimpan.";
        } else {
            $_SESSION['error_message'] = "Error: " . $connect->error;
            echo "Error: " . $connect->error; // Tambahkan ini untuk melihat pesan error
        }
    } else {
        $_SESSION['error_message'] = "Error: " . $connect->error;
        echo "Error: " . $connect->error; // Tambahkan ini untuk melihat pesan error
    }

    header('Location: index.php');
    exit();
}
?>
