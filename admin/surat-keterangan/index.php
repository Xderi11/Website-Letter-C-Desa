<?php 
include ('../part/akses.php');
include ('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');

$no_persil = "";

if(isset($_POST['submit'])){
    $no_persil = $_POST['no_persil'];

    // Query untuk memeriksa apakah nomor persil ada di database
    $query_check = "SELECT * FROM pemilik WHERE no_persil = '$no_persil'";
    $result_check = mysqli_query($connect, $query_check);

    if(mysqli_num_rows($result_check) > 0){
        // Data ditemukan, arahkan ke halaman detail
        header("Location: detail.php?detail=$no_persil");
        exit();
    } else {
        // Data tidak ditemukan, tampilkan pesan kesalahan
        $error_message = "Nomor Persil tidak ditemukan.";
    }
}

// Tutup koneksi database
mysqli_close($connect);
?>

<aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <?php  
            if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
              echo '<img src="../../assets/img/ava-admin-female.png" class="img-circle" alt="User Image">';
            } else if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Kepala Desa')){
              echo '<img src="../../assets/img/ava-kades.png" class="img-circle" alt="User Image">';
            }
          ?>
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['lvl']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="../dashboard/">
            <i class="fas fa-tachometer-alt"></i> <span>&nbsp;&nbsp;Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-database"></i> <span>&nbsp;&nbsp;Data Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="../data-tanah/"><i class="fa fa-circle-notch"></i> Data Tanah</a>
            </li>
            <li>
              <a href="../data-pemilik/"><i class="fa fa-circle-notch"></i> Data Pemilik</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="../penduduk/">
            <i class="fas fa-tachometer-alt"></i> <span>&nbsp;&nbsp;Data Letter C</span>
          </a>
        </li>
        <li class="treeview">
            <a href="#">
              <i class="fas fa-exchange-alt"></i> <span>Transaksi</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="../kepemilikan/"><i class="fa fa-circle-notch"></i> Kepemilikan</a>
              </li>
              <li>
                <a href="../perubahan/"><i class="fa fa-circle-notch"></i> Perubahan</a>
              </li>
            </ul>
        </li>
        <li class="active treeview">
          <a href="#">
            <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li >
              <a href="../letter-c/"><i class="fa fa-circle-notch"></i> Kepemilikan</a>
            </li>
            <li >
              <a href="../letter-c/"><i class="fa fa-circle-notch"></i> Letter C</a>
            </li>
            <li class="active">
              <a href="../surat-keterangan/"><i class="fa fa-circle-notch"></i> Surat Keterangan</a>
            </li>
          </ul>
        </li>
      </ul>
    </section>
</aside>


<style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .card {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Pengecekan No Persil</h1>
        <ol class="breadcrumb">
            <li><a href="../../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="active">Surat Keterangan</li>
        </ol>
    </section>
  
    <section class="content">      
        <div class="row">
            <div class="col-md-12">
                <?php if(isset($error_message)) { echo "<div class='alert alert-danger'><center>$error_message</center></div>"; } ?>
                <div class="container" style="max-height:cover; padding-top:60px; position:relative; min-height: 100%;" align="center">
                    <div class="card col-md-4">
                        <div class="card-content">
                            <div class="card-body">
                                <form action="index.php" method="post"> 
                                    <img src="../../assets/img/logo-kepri2.png"><hr>
                                    <label style="font-weight: 700;"><i class="fas fa-id-card"></i> NOMOR PERSIL</label>
                                    <input type="text" class="form-control form-control-md" name="no_persil" placeholder="Masukkan No Persil Anda..." required>
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-info btn-md"><i class="fas fa-search"></i> CEK NOMOR PERSIL</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?php include ('../part/footer.php'); ?>