<?php 
  include ('../part/header.php');
?>

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
                	<img src="../../../../assets/img/logo-jombang1.png"><hr>
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

<?php 
  include ('../buat_surat/part/footer.php');
?>