<?php
	session_start();
 
	if(isset($_SESSION['admin'])){
		header('location:../admin/dashboard/');
	}else if(isset($_SESSION['kades'])){
		header('location:../admin/dashboard/');
	}
?>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../assets/img/mini-logo.png">
	<title>Login Page</title>   
	<link rel="stylesheet" href="../assets/fontawesome-5.10.2/css/all.css">
	<link rel="stylesheet" href="../assets/bootstrap-4.3.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="login.css">
	<style>
		.center-logo {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 30px; /* Adjust the margin as needed */
			margin-bottom: -130px; /* Adjust the margin as needed */
		}
		.center-logo img {
			width: 200px; /* Adjust the width as needed */
			height: auto; /* Maintain aspect ratio */
		}
    .center-text {
	  font-size : 20pt;
      text-align: center;
      font-weight: bold;
      color: black;
	  margin-top: 130px;
    }
	.center-kabupaten {
	  font-size : 20pt;
      text-align: center;
      font-weight: bold;
      color: black;
	  margin-top: 3px;
	  margin-bottom: -170px;
    }
	</style>
</head>
<body>
<div class="container">
	<?php 
		if(isset($_GET['pesan'])){
			if($_GET['pesan']=="login-gagal"){
				echo "<div class='alert alert-danger'><center>Username atau Password Anda salah!</center></div>";
			}
		}
	?>
	<div class="center-logo">
		<img src="../assets/img/logo1.png" alt="Logo">
	</div>
  <div class="center-text">
    DESA TANJUNG BERLIAN BARAT
  </div>
  <div class="center-kabupaten">
	KABUPATEN KARIMUN
  </div>
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header text-center mt-2">
				<h3>Silahkan Login</h3>
			</div>
			<div class="card-body">
				<form method="post" action="aksi-login.php">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" name="username" placeholder="username" required>			
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" name="password" placeholder="password" required>
					</div><br>
					<div class="form-group">
						<input type="submit" value="Login" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					<span style="font-size:8pt">Copyright &copy; 2024 <a href="../" class="text-decoration-none text-white">Letter C</a></span>
				</div>
				<div class="d-flex justify-content-center">
					<span class="text-white" style="font-size:8pt">All rights reserved.</span>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>