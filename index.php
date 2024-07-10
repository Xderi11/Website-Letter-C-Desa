<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="assets/img/logo-karimun-mini.png">
	<title>LETTER-C</title>
  	<link rel="stylesheet" href="assets/fontawesome-5.10.2/css/all.css">
	<link rel="stylesheet" href="assets/bootstrap-4.3.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css" />
	<style type="text/css">
		body{
			background:url('assets/img/background-kepri.jpg');
			height: 100%;
		    background-position: center;
		    background-repeat: no-repeat;
		    background-size: cover;
		    background-attachment:fixed;
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
    </style>
</head>
<body>
<div>
    <navbar class="navbar navbar-expand-lg navbar-dark bg-custom w-100">
        <a class="navbar-brand ml-4 mt-1" href="../"><img src="assets/img/letterc-logo.png"></a>
        <button class="navbar-toggler mr-4 mt-3" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav ml-auto mt-lg-3 mr-5 position-relative text-right">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tentang/">TENTANG <b></b></a>
                </li>
                <li class="nav-item active ml-5">
                    <?php
                        session_start();
                        if(empty($_SESSION['username'])){
                            echo '<a class="btn btn-dark" href="login/"><i class="fas fa-sign-in-alt"></i>&nbsp;LOGIN</a>';
                        }else if(isset($_SESSION['lvl'])){
                            echo '<a class="btn btn-transparent text-light" href="admin/"><i class="fa fa-user-cog"></i> '; echo $_SESSION['lvl']; echo '</a>';
                            echo '<a class="btn btn-transparent text-light" href="login/logout.php"><i class="fas fa-power-off"></i></a>';
                        }
                    ?>
                </li>
            </ul>
        </div>
    </navbar>
</div>



      </ul>
    </nav>
	<div class="container" style="max-height:cover; padding-top:50px; padding-bottom:120px" align="center">
	<img src="assets/img/logo1.png"><hr>
	<a class="text-dark" style="font-size:18pt"><strong>WEB APLIKASI PELAYANAN SURAT ADMINISTRASI DESA</strong></a><br>
	<?php  
		include('config/koneksi.php');

        $qTampilDesa = mysqli_query($connect, "SELECT * FROM profil_desa WHERE id_profil_desa = '1'");
        foreach($qTampilDesa as $row){
    ?>
	<a class="text-dark" style="font-size:15pt; text-transform: uppercase;"><strong>DESA <?php echo $row['nama_desa']; ?></strong><br>
	<a class="text-dark" style="font-size:15pt; text-transform: uppercase;"><strong><?php echo $row['kabupaten']; ?></strong></a><hr>
	<?php  
		}
	?>
</div>
<div class="footer bg-transparent text-center mb-3 ">
    <span class="text-dark"><strong>Copyright &copy; 2024 <a href="#" class="text-decoration-none text-dark">LETTER-C</a>.</strong></span>
</div>

</body>
</html>