<?php
	include ('../../config/koneksi.php');

	$id		= $_GET['id'];
	$qHapus		= mysqli_query($connect, "DELETE FROM kepemilikan_letter_c WHERE id_kepemilikan = '$id'");

	if($qHapus){
		header('location:index.php');
	} else {
		header('location:index.php?pesan=gagal-menghapus');
	}
?>