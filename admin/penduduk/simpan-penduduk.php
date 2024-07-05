<?php
    include ('../../config/koneksi.php');

    if (isset($_POST['submit'])){
        $nama_pemilik = $_POST['fnama_pemilik'];
        $alamat_pemilik = addslashes($_POST['falamat_pemilik']);
        $no_persil = $_POST['fno_persil'];
        $kelas_desa = $_POST['fkelas_desa'];
        $luas_milik = $_POST['fluas_milik'];
        $jenis_tanah = $_POST['fjenis_tanah'];
        $tanggal = $_POST['ftanggal'];
        $sebab_perubahan = $_POST['fsebab_perubahan'];


        $qCekPenduduk = mysqli_query($connect, "SELECT * FROM penduduk WHERE no_persil='$no_persil'");
        $row          = mysqli_num_rows($qCekPenduduk);

        if($row > 0){
            header('location:index.php?pesan=gagal-menambah');
        }else{
            $qTambahPenduduk = "INSERT INTO penduduk VALUES(NULL, '$nama_pemilik', '$alamat_pemilik', '$no_persil', '$kelas_desa', '$luas_milik', '$jenis_tanah', '$tanggal', '$sebab_perubahan')";
            $tambahPenduduk = mysqli_query($connect, $qTambahPenduduk);
            if($tambahPenduduk){
                header("location:index.php");
            }
        }
    }
?>