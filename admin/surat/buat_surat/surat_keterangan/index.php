<?php 
  include ('../part/header.php');
?>

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
			background-image: url("../../../../assets/img/background-kepri.jpg"); /* Replace with your image path */
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			background-attachment: fixed;
		}
		.container {
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
		}
		.card {
			background-color: rgba(255, 255, 255, 0.9); /* Adding a background color for better readability */
			border-radius: 10px; /* Optional: to make the container have rounded corners */
		}
	</style>
</head>
<body>
	
<div class="container" style="max-height:cover; padding-top:60px; position:relative; min-height: 100%;" align="center">
  	<div class="card col-md-4">
        <div class="card-content">
            <div class="card-body">
                <form action="info-surat.php" method="post"> 
    	            <?php 
        	          if(isset($_GET['pesan'])){
            		      if($_GET['pesan']=="gagal"){
                 		    echo "<div class='alert alert-danger'><center>Nomor Persil tidak terdaftar. Silahkan Cek Lagi!</center></div>";
                    	}
                  	}
                	?>
                	<img src="../../../../assets/img/logo-kepri2.png"><hr>
                  	<label style="font-weight: 700;"><i class="fas fa-id-card"></i> NOMOR PERSIL</label>
                  	<input type="text" class="form-control form-control-md"  name="fno_persil" placeholder="Masukkan No Persil Anda..." required>
                   
                  	<div class="form-control-position">
                    	<i class="ft-search primary font-medium-4"></i>
                  	</div>
                  	<br>
                  	<button type="submit" class="btn btn-info btn-md"><i class="fas fa-search"></i> CEK NOMOR PERSIL</button>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>
