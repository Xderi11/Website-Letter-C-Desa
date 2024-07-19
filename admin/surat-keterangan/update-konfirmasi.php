<?php
// Include koneksi database
include('../../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $no_surat = mysqli_real_escape_string($connect, $_POST['fno_surat']);
    $nama_pemilik = mysqli_real_escape_string($connect, $_POST['fnama_pemilik']);
    $alamat_pemilik = mysqli_real_escape_string($connect, $_POST['falamat_pemilik']);
    $no_persil = mysqli_real_escape_string($connect, $_POST['fno_persil']);
    $kelas_desa = mysqli_real_escape_string($connect, $_POST['fkelas_desa']);
    $luas_milik = mysqli_real_escape_string($connect, $_POST['fluas_milik']);
    $jenis_tanah = mysqli_real_escape_string($connect, $_POST['fjenis_tanah']);
    $tanggal = mysqli_real_escape_string($connect, $_POST['ftanggal']);
    $sebab_perubahan = mysqli_real_escape_string($connect, $_POST['fsebab_perubahan']);
    $keperluan = mysqli_real_escape_string($connect, $_POST['fkeperluan']);
    $id_pejabat_desa = mysqli_real_escape_string($connect, $_POST['ft_tangan']);
    $id_sk = mysqli_real_escape_string($connect, $_POST['id']); // Hidden field to identify the record

    // Query untuk menyimpan data ke tabel surat_keterangan
    $query = "
        INSERT INTO surat_keterangan (
            no_surat,
            nama_pemilik,
            alamat_pemilik,
            no_persil,
            kelas_desa,
            luas_milik,
            jenis_tanah,
            tanggal,
            sebab_perubahan,
            keperluan,
            id_pejabat_desa
        ) VALUES (
            '$no_surat',
            '$nama_pemilik',
            '$alamat_pemilik',
            '$no_persil',
            '$kelas_desa',
            '$luas_milik',
            '$jenis_tanah',
            '$tanggal',
            '$sebab_perubahan',
            '$keperluan',
            '$id_pejabat_desa'
        )
    ";

    // Eksekusi query
    if (mysqli_query($connect, $query)) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='somepage.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . mysqli_error($connect) . "'); window.location.href='detail.php?detail=$no_persil';</script>";
    }

    // Tutup koneksi database
    mysqli_close($connect);
} else {
    // Jika bukan metode POST
    echo "<script>alert('Permintaan tidak valid.'); window.location.href='detail.php?detail=$no_persil';</script>";
}
?>
