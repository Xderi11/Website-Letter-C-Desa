<?php
	include ('../../../../config/koneksi.php');
	include ('../part/header.php');
		 
	$no_persil = $_POST['fno_persil'];
	 
	$qCekNo_persil = mysqli_query($connect,"SELECT * FROM penduduk WHERE no_persil = '$no_persil'");
	$row = mysqli_num_rows($qCekNo_persil);
	 
	if($row > 0){
		$data = mysqli_fetch_assoc($qCekNo_persil);
		if($data['no_persil']==$no_persil){
			$_SESSION['no_persil'] = $no_persil;
?>
<body class="bg-light">
	<div class="container" style="max-height:cover; padding-top:30px;  padding-bottom:60px; position:relative; min-height: 100%;">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<h5 class="card-header"><i class="fas fa-envelope"></i> INFORMASI SURAT</h5>
					<br>
					<div class="container-fluid">
						<div class="row">
							<a class="col-sm-6"><h5><b>SURAT KETERANGAN</b></h5></a>
							<a class="col-sm-6"><h5><b>NOMOR SURAT : -</b></h5></a>
						</div>
					</div>
					<hr>
					<form method="post" action="simpan-surat.php">
						<h6 class="container-fluid" align="right"><i class="fas fa-user"></i> Informasi Pribadi</h6><hr width="97%">
						<div class="row">
							<div class="col-sm-6">
							    <div class="form-group">
						           	<label class="col-sm-12" style="font-weight: 500;">Nama Lengkap</label>
						           	<div class="col-sm-12">
						               	<input type="text" name="fnama_pemilik" class="form-control" style="text-transform: capitalize;" value="<?php echo $data['nama_pemilik']; ?>" readonly>
						           	</div>
						        </div>
							</div>
							<div class="col-sm-6">
							    <div class="form-group">
						           	<label class="col-sm-12" style="font-weight: 500;">Alamat Pemilik</label>
						           	<div class="col-sm-12">
						               	<input type="text" name="falamat_pemilik" class="form-control" style="text-transform: capitalize;" value="<?php echo $data['alamat_pemilik']; ?>" readonly>
						           	</div>
						        </div>
							</div>
							<div class="col-sm-6">
							    <div class="form-group">
						           	<label class="col-sm-12" style="font-weight: 500;">Nomor Persil</label>
						           	<div class="col-sm-12">
						               	<input type="text" name="fno_persil" class="form-control" style="text-transform: capitalize;" value="<?php echo $data['no_persil']; ?>" readonly>
						           	</div>
						        </div>
							</div>
							<div class="col-sm-6">
							    <div class="form-group">
						           	<label class="col-sm-12" style="font-weight: 500;">Kelas Desa</label>
						           	<div class="col-sm-12">
						               	<input type="text" name="fkelas_desa" class="form-control" style="text-transform: capitalize;" value="<?php echo $data['kelas_desa']; ?>" readonly>
						           	</div>
						        </div>
							</div>
							<div class="col-sm-6">
							    <div class="form-group">
						           	<label class="col-sm-12" style="font-weight: 500;">Luas Milik</label>
						           	<div class="col-sm-12">
						               	<input type="text" name="fluas_milik" class="form-control" style="text-transform: capitalize;" value="<?php echo $data['luas_milik']; ?>" readonly>
						           	</div>
						        </div>
							</div>
							<div class="col-sm-6">
							    <div class="form-group">
						           	<label class="col-sm-12" style="font-weight: 500;">Jenis Tanah</label>
						           	<div class="col-sm-12">
						               	<input type="text" name="fjenis_tanah" class="form-control" style="text-transform: capitalize;" value="<?php echo $data['jenis_tanah']; ?>" readonly>
						           	</div>
						        </div>
							</div>
							<div class="col-sm-6">
							    <div class="form-group">
						           	<label class="col-sm-12" style="font-weight: 500;">Tanggal</label>
						           	<div class="col-sm-12">
						           		<?php
											$tanggal = date($data['tanggal']);
											$tgl = date('d ', strtotime($tanggal));
											$bln = date('F', strtotime($tanggal));
											$thn = date(' Y', strtotime($tanggal));
											$blnIndo = array(
											    'January' => 'Januari',
											    'February' => 'Februari',
											    'March' => 'Maret',
											    'April' => 'April',
											    'May' => 'Mei',
											    'June' => 'Juni',
											    'July' => 'Juli',
											    'August' => 'Agustus',
											    'September' => 'September',
											    'October' => 'Oktober',
											    'November' => 'November',
											    'December' => 'Desember'
											);
										?>
						               	<input type="text" name="ftanggal" class="form-control" style="text-transform: capitalize;" value="<?php echo  $tgl . $blnIndo[$bln] . $thn; ?>" readonly>
						           	</div>
						        </div>
							</div>
							<div class="col-sm-6">
							    <div class="form-group">
						           	<label class="col-sm-12" style="font-weight: 500;">Sebab Perubahan</label>
						           	<div class="col-sm-12">
						               	<input type="text" name="fsebab_perubahan" class="form-control" style="text-transform: capitalize;" value="<?php echo $data['sebab_perubahan']; ?>" readonly>
						           	</div>
						        </div>
							</div>
						</div>
						</div>
						<br>
						<h6 class="container-fluid" align="right"><i class="fas fa-edit"></i> Formulir Surat</h6><hr width="97%">
						<div class="row">
						  	<div class="col-sm-12">
						      	<div class="form-group">
						           	<label class="col-sm-12" style="font-weight: 500;">Keperluan Surat</label>
						           	<div class="col-sm-12">
						               	<input type="text" name="fkeperluan" class="form-control" style="text-transform: capitalize;" placeholder="Masukkan Keperluan Surat" required>
						           	</div>
						        </div>
						  	</div>
						</div>
						<hr width="97%">
						<div class="container-fluid">
		                	<input type="reset" class="btn btn-warning" value="Batal">
		                	<input type="submit" name="submit" class="btn btn-info" value="Submit">
		              	</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

<?php 
		}
	}else{
		header("location:index.php?pesan=gagal");
	}

	include ('../part/footer.php');
?>