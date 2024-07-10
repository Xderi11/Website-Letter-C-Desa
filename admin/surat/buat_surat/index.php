<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../../../assets/img/logo2.png">
	<title>LETTER-C</title>
  	<link rel="stylesheet" href="../../../assets/fontawesome-5.10.2/css/all.css">
	<link rel="stylesheet" href="../../../assets/bootstrap-4.3.1/dist/css/bootstrap.min.css">
	<style>
		body {
			background-image: url('../../../assets/img/background-kepri.jpg'); /* Replace with your image path */
			background-size: cover;
			background-position: center;
		}
		.container-fluid {
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
		}
		.square-container {
			width: 300px; /* Adjust the size as needed */
			height: 300px;
			padding-top: 30px;
			padding-bottom: 30px;
			margin-top: -200px; /* Adjust this value to move it up slightly */
			background-color: rgba(255, 255, 255, 0.9); /* Adding a background color for better readability */
			border-radius: 10px; /* Optional: to make the container have rounded corners */
		}
	</style>
</head>
<body>
	
<div class="container-fluid">
	<div class="square-container">
		<div>
			<?php 
   	        	if(isset($_GET['pesan'])){
                   	if($_GET['pesan']=="berhasil"){
                  		echo "<div class='alert alert-success'><center>Berhasil membuat surat. Silahkan ambil surat!</center></div>";
              		}
              	}
           	?>
		</div>
		<div class="row justify-content-center">
			<div class="col mt-4">
		    	<div class="card">
		      		<img src="../../../assets/img/logo-buat-surat.jpg" class="card-img-top" alt="...">
		      		<div class="card-body text-center">
		        		<h5 class="card-title">SURAT KETERANGAN</h5><br><br>
		        		<a href="surat_keterangan/" class="btn btn-info">BUAT SURAT</a>
		        		<a href="../../../admin/dashboard" class="btn btn-secondary mt-2">BACK TO DASHBOARD</a>
		      		</div>
		    	</div>
		  	</div>
		</div>
	</div>
</div>

</body>
</html>
