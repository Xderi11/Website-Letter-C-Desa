<?php
include ('../../config/koneksi.php');

$id = $_POST['id'];
$nama_pemilik = $_POST['fnama_pemilik'];
$alamat_pemilik = addslashes($_POST['falamat_pemilik']);
$no_persil = $_POST['fno_persil'];
$kelas_desa = $_POST['fkelas_desa'];
$luas_milik = $_POST['fluas_milik'];
$jenis_tanah = $_POST['fjenis_tanah'];
$tanggal = $_POST['ftanggal'];
$pajak_bumi = $_POST['fpajak_bumi']; 
$keterangan_tanah = $_POST['fketerangan_tanah']; 

$qUpdate = "UPDATE kepemilikan_letter_c SET nama_pemilik = '$nama_pemilik', alamat_pemilik = '$alamat_pemilik', no_persil = '$no_persil', kelas_desa = '$kelas_desa', luas_milik = '$luas_milik', jenis_tanah = '$jenis_tanah', tanggal = '$tanggal', pajak_bumi = '$pajak_bumi', keterangan_tanah = '$keterangan_tanah' WHERE id_kepemilikan='$id'";
$update = mysqli_query($connect, $qUpdate);

if($update){
    header('location:../penduduk/');
}else{
    echo "<script>alert('Gagal mengubah data Letter C'); window.location.href='../penduduk/';</script>";
}
?>
