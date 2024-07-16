<?php
include ('../../config/koneksi.php');

if (isset($_POST['submit'])){
    $no_persil = $_POST['fno_persil'];
    $kelas_desa = $_POST['fkelas_desa'];
    $luas_milik = $_POST['fluas_milik'];
    $jenis_tanah = $_POST['fjenis_tanah'];
    $pajak_bumi = $_POST['fpajak_bumi'];
    $keterangan_tanah = $_POST['fketerangan_tanah'];

    $qCekTanah = mysqli_query($connect, "SELECT * FROM tanah WHERE no_persil='$no_persil'");
    $row = mysqli_num_rows($qCekTanah);

    if($row > 0){
        header('location:index.php?pesan=gagal-menambah');
    } else {
        $qTambahTanah = "INSERT INTO tanah (no_persil, kelas_desa, luas_milik, jenis_tanah, pajak_bumi, keterangan_tanah) 
                        VALUES ('$no_persil', '$kelas_desa', '$luas_milik', '$jenis_tanah', '$pajak_bumi', '$keterangan_tanah')";
        $tambahTanah = mysqli_query($connect, $qTambahTanah);
        if($tambahTanah){
            header("location:index.php");
        } else {
            echo ("<script LANGUAGE='JavaScript'>window.alert('Gagal menambah data tanah'); window.location.href='index.php';</script>");
        }
    }
}
?>