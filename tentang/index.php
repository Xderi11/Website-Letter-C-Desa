<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../assets/img/mini-logo.png">
	<title>e-SuratDesa</title>
	<link rel="stylesheet" href="../assets/fontawesome-5.10.2/css/all.css">
	<link rel="stylesheet" href="../assets/bootstrap-4.3.1/dist/css/bootstrap.min.css">
	<style type="text/css">
		.img-circle {
			width: 150px;
			height: 150px;
			border-radius: 100%;
		}
	</style>
	<style>
		.bg-custom {
			background-color: #000f61;
		}
		.navbar-brand {
			margin-left: 0 !important;
			margin-top: 0 !important;
		}
		.navbar-nav .nav-item {
			margin-left: 1rem;
		}
		.navbar-nav .nav-link {
			padding-top: 0.5rem;
			padding-bottom: 0.5rem;
		}
		.navbar-toggler {
			margin-right: 0;
			margin-top: 0;
		}
		.background-image {
			background-image: url('../assets/img/background-kepri.jpg'); /* Ganti dengan URL gambar latar belakang Anda */
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			min-height: 100vh; /* Sesuaikan dengan tinggi minimum halaman */
			width: 100%;
			position: relative;
		}
		.container-fluid {
			position: relative;
			z-index: 2;
			padding-top: 100px; /* Menyesuaikan ruang untuk navbar */
		}
	</style>
</head>
<body>
	<div class="background-image">
		<nav class="navbar navbar-expand-lg navbar-dark bg-custom w-100 fixed-top">
			<a class="navbar-brand ml-4 mt-1" href="../"><img src="../assets/img/letterc-logo.png"></a>
			<button class="navbar-toggler mr-4 mt-3" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
				<ul class="navbar-nav ml-auto mt-lg-3 mr-5 position-relative text-right">
					<li class="nav-item">
						<a class="nav-link" href="../index.php">HOME</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="index.php">TENTANG <b></b></a>
					</li>
					<li class="nav-item active ml-5">
						<?php
							session_start();
							if(empty($_SESSION['username'])){
								echo '<a class="btn btn-dark" href="login/"><i class="fas fa-sign-in-alt"></i>&nbsp;LOGIN</a>';
							} else if(isset($_SESSION['lvl'])){
								echo '<a class="btn btn-transparent text-light" href="admin/"><i class="fa fa-user-cog"></i> '; echo $_SESSION['lvl']; echo '</a>';
								echo '<a class="btn btn-transparent text-light" href="login/logout.php"><i class="fas fa-power-off"></i></a>';
							}
						?>
					</li>
				</ul>
			</div>
		</nav>

		<div class="container-fluid">
			<div class="container shadow p-3 mb-5 mt-lg-5 bg-white rounded">
				<div style="max-height:cover; padding-top:30px; padding-bottom:60px; position:relative; min-height: 100%;">
					<div class="card-body">
						<div class="card-text">
							<p>
								<label style="font-weight: 700;font-size: 25px"><i class="fas fa-info-circle"></i> APA ITU Letter C?</label>
								<hr>
								<blockquote>
								Surat tanah letter C adalah sebuah tanda bukti atau identitas kepemilikan tanah oleh seseorang yang berada di desa atau kampung.<b><a href="#" style="text-decoration:none"></a></b> Bentuk surat tradisional ini merupakan bukti kepemilikan tanah yang sudah diberikan secara turun-temurun.
									<br><br>
								</blockquote>
							</p>
							<br>
							<p class="card-text">
								<label style="font-weight: 700;font-size: 25px"><i class="fas fa-shield-alt"></i> </label>
							</p>
							<hr>
							<b></b><b>LETTER-C</b>
						</div>
						<br><br><br>
						<div class="row text-center">
							<div class="col-md-12">
								<img src="../assets/img/logo1.png" class="img"><br><br>
								<p class="text-muted"> <b><a href="#" style="text-decoration:none"></a></b></p>
							</div>
							<div class="col-md-3"></div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="footer bg-dark text-center">
		<span class="text-light"><strong>Copyright &copy; 2024 <a href="../" class="text-decoration-none text-white">LETTER-C</a>.</strong></span>
	</div>

	<!-- Include necessary scripts -->
	<script src="../assets/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../assets/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="../assets/AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>
