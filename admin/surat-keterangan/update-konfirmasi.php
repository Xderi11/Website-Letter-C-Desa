<?php
include ('../../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ft_tangan = $_POST['ft_tangan'];
    $fno_surat = $_POST['fno_surat'];
    $fkeperluan = $_POST['fkeperluan'];
    $fnama_pemilik = $_POST['fnama_pemilik'];
    $falamat_pemilik = $_POST['falamat_pemilik'];
    $fno_persil = $_POST['fno_persil'];
    $fkelas_desa = $_POST['fkelas_desa'];
    $fluas_milik = $_POST['fluas_milik'];
    $fjenis_tanah = $_POST['fjenis_tanah'];
    $ftanggal = $_POST['ftanggal'];
    $fketerangan_tanah = $_POST['fketerangan_tanah'];
    $fstatus_kepemilikan = $_POST['fstatus_kepemilikan'];

    $query = "
    INSERT INTO surat_keterangan (id_sk, id_pejabat_desa, no_surat, keperluan, nama_pemilik, alamat_pemilik, no_persil, kelas_desa, luas_milik, jenis_tanah, tanggal, keterangan_tanah, status_kepemilikan)
    VALUES (NULL, '$ft_tangan', '$fno_surat', '$fkeperluan', '$fnama_pemilik', '$falamat_pemilik', '$fno_persil', '$fkelas_desa', '$fluas_milik', '$fjenis_tanah', '$ftanggal', '$fketerangan_tanah', '$fstatus_kepemilikan')
    ";

    if (mysqli_query($connect, $query)) {
        // Redirect to informasi.php
        header('Location: informasi.php');
        exit;
    } else {
        // Redirect to permintaan-surat.php
        header('Location: permintaan-surat.php');
        exit;
    }
} else {
    // Redirect to permintaan-surat.php
    header('Location: permintaan-surat.php');
    exit;
}
?>
