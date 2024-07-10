<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../assets/img/logo2.png">
	<title>LETTTER-C</title>
  	<link rel="stylesheet" href="../assets/fontawesome-5.10.2/css/all.css">
	<link rel="stylesheet" href="../assets/bootstrap-4.3.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../style.css" />
</head>
<nav>
      <div class="">
        <img src="my-avatar.png" alt="my-avatar" />
      </div>
      <ul>
        <li>
		<a class="nav-link" href="#"><i class="fas fa-home"></i>&nbsp;HOME</a>
        </li>
        <li>
		<a class="nav-link" href="surat/">BUAT SURAT</a>
        </li>
        <li>
		<a class="nav-link" href="tentang/">TENTANG <b>e-SuratDesa</b></a>
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
<div class="container-fluid">
	<div style="max-height:cover; padding-top:30px; padding-bottom:60px; position:relative; min-height: 100%;">
		<div>
			<?php 
   	        	if(isset($_GET['pesan'])){
                   	if($_GET['pesan']=="berhasil"){
                  		echo "<div class='alert alert-success'><center>Berhasil membuat surat. Silahkan ambil surat!</center></div>";
              		}
              	}
           	?>
		</div>
		<div class="row">
			<div class="col-sm-3 mt-4">
		    	<div class="card">
		      		<img src="../assets/img/menu-surat.jpg" class="card-img-top" alt="...">
		      		<div class="card-body text-center">
		        		<h5 class="card-title">SURAT KETERANGAN</h5><br><br>
		        		<a href="surat_keterangan/" class="btn btn-info">BUAT SURAT</a>
		      		</div>
		    	</div>
		  	</div>
		  	
		</div>
	</div>
</div>
<div class="footer bg-dark text-center">
    <span class="text-light"><strong>Copyright &copy; 2019 <a href="../" class="text-decoration-none text-white">e-SuratDesa</a>.</strong> All rights reserved.</span>
</div>
</body>
</html>