<?php 
	include ('../../config/koneksi.php');
	include ('excel_reader2.php');

	$target = basename($_FILES['datapenduduk']['name']) ;
	move_uploaded_file($_FILES['datapenduduk']['tmp_name'], $target);
	chmod($_FILES['datapenduduk']['name'],0777);
	$data = new Spreadsheet_Excel_Reader($_FILES['datapenduduk']['name'],false);
	$jumlah_baris = $data->rowcount($sheet_index=0);
	$berhasil = 0;
	for ($i=2; $i<=$jumlah_baris; $i++){
		$nama_pemilik  = $data->val($i, 1);
		$alamat_pemilik  = addslashes($data->val($i, 2));
		$no_persil  = $data->val($i, 3);
		$kelas_desa  = $data->val($i, 4);
		$luas_milik  = $data->val($i, 5);
		$jenis_tanah  = $data->val($i, 6);
		$tanggal  = $data->val($i, 7);
		$sebab_perubahan  = $data->val($i, 8);
		
		if($no_persil != "" && $nama_pemilik != "" && $alamat_pemilik != "" && $no_persil != "" && $kelas_desa != "" && $luas_milik != "" && $jenis_tanah != "" && $tanggal != "" && $sebab_perubahan != "" ){
			mysqli_query($connect,"INSERT INTO penduduk VALUES(NULL, '$nama_pemilik','$alamat_pemilik','$no_persil','$kelas_desa','$luas_milik','$jenis_tanah','$tanggal','$sebab_perubahan')");
			$berhasil++;
		}
	}
	unlink($_FILES['datapenduduk']['name']);
	header("location:index.php");
?>