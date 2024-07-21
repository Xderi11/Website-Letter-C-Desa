<?php
  include ('../part/akses.php');
  include ('../part/header.php');
?>

<style>
  .background-image {
    background-image: url('../../assets/img/background-kepri.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 100vh;
    width: 100%;
  }
  .content-wrapper, .main-sidebar, .footer {
    background: transparent;
  }
  .small-box {
    background: rgba(255, 255, 255, 0.8);
  }
</style>

<div class="background-image">
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
        <li class="active">
          <a href="#">
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
        <li >
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
          
        <?php
          if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
        ?>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="../letter-c/"><i class="fa fa-circle-notch"></i> Letter C</a>
            </li>
            <li>
              <a href="../surat-keterangan/"><i class="fa fa-circle-notch"></i> Surat Keterangan</a>
            </li>
          </ul>
        </li>
        <?php 
          }
        ?>
      </ul>
    </section>
  </aside>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>Dashboard</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <?php 
          if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
        ?>
        <div class="col-lg-4 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>
                <?php
                  include ('../../config/koneksi.php');

                  $qTampil = mysqli_query($connect, "SELECT * FROM tanah");
                  $jumlahTanah = mysqli_num_rows($qTampil);
                  echo $jumlahTanah;
                ?>
              </h3>
              <p>Data Tanah</p>
            </div>
            <div class="icon">
              <i class="fas fa-users" style="font-size:70px"></i>
            </div>
            <a href="../data-tanah/" class="small-box-footer">Lihat detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>
                <?php
                  // Query to count pending requests
                  $qTampil = mysqli_query($connect, "SELECT * FROM pemilik");
                  // Check if the query executed successfully
                  if ($qTampil) {
                    // Count the number of rows in the result set
                    $jumlahPemilik = mysqli_num_rows($qTampil);
                    echo $jumlahPemilik;
                  } else {
                    // If query fails, display an error message
                    echo "Error: " . mysqli_error($connect);
                  }
                ?>
              </h3>
              <p>Pemilik Tanah Aktif</p>
            </div>
            <div class="icon">
              <i class="fas fa-envelope-open-text" style="font-size:70px"></i>
            </div>
            <a href="../kepemilikan/" class="small-box-footer">Lihat detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>
                <?php
                  $qTampil = mysqli_query($connect, "SELECT * FROM kepemilikan_letter_c ");
                  $jumlahKepemilikan = mysqli_num_rows($qTampil);
                  echo $jumlahKepemilikan;
                ?>
              </h3>
              <p>Data Letter C</p>
            </div>
            <div class="icon">
              <i class="fas fa-envelope" style="font-size:70px"></i>
            </div>
            <a href="../penduduk/" class="small-box-footer">Lihat detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <?php 
          } else if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Kepala Desa')){
        ?>

        <div class="col-lg-1"></div>

        <div class="col-lg-5 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>
                <?php
                  include ('../../config/koneksi.php');

                  $qTampil = mysqli_query($connect, "SELECT * FROM penduduk");
                  $jumlahPenduduk = mysqli_num_rows($qTampil);
                  echo $jumlahPenduduk;
                ?>
              </h3>
              <p>Data Letter C</p>
            </div>
            <div class="icon">
              <i class="fas fa-users" style="font-size:70px"></i>
            </div>
            <a href="../penduduk/" class="small-box-footer">Lihat detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-5 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>
                <?php
                  $qTampil = mysqli_query($connect, "SELECT * FROM surat_keterangan WHERE status_surat='selesai' ");
                  $jumlahPermintaanSurat = mysqli_num_rows($qTampil);
                  echo $jumlahPermintaanSurat;
                ?>
              </h3>
              <p>Laporan Surat Administrasi Desa - Surat Keluar</p>
            </div>
            <div class="icon">
              <i class="fas fa-envelope" style="font-size:70px"></i>
            </div>
            <a href="../laporan/" class="small-box-footer">Lihat detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-1"></div>

        <?php  
          }
        ?>
      </div>

      <div class="container-fluid">
        <div class="row">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Welcome Home!</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>

            <div class="box-body">
              <div class="row">
                <form class="form-horizontal" method="post" action="simpan-penduduk.php">
                  <div class="col-md-12">
                    <div class="col-md-4" style="text-align: center;">
                      <img style="max-width:300px; width:100%; height:auto;" src="../../assets/img/logo1.png"><br>
                      <?php  
                        $qTampilDesa = mysqli_query($connect, "SELECT * FROM profil_desa WHERE id_profil_desa = '1'");
                        foreach($qTampilDesa as $row){
                      ?>
                      <p style="font-size: 20pt; font-weight: 500; text-transform: uppercase;"><strong>DESA <?php echo $row['nama_desa']; ?></strong><hr>
                      <?php  
                        }
                      ?>
                    </div>

                    <div class="col-md-8">
                      <div class="pull-right">
                        <?php
                          $tanggal = date('D d F Y');
                          $hari = date('D', strtotime($tanggal));
                          $bulan = date('F', strtotime($tanggal));
                          $hariIndo = array(
                            'Mon' => 'Senin',
                            'Tue' => 'Selasa',
                            'Wed' => 'Rabu',
                            'Thu' => 'Kamis',
                            'Fri' => 'Jumat',
                            'Sat' => 'Sabtu',
                            'Sun' => 'Minggu',
                          );
                          $bulanIndo = array(
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
                          echo $hariIndo[$hari] . ', ' . date('d ') . $bulanIndo[$bulan] . date(' Y');
                        ?>
                      </div><br>

                      <div style="font-size: 35pt; font-weight: 500;">
                        <p>Halo, <strong><?php echo $_SESSION['lvl']; ?></strong></p>
                      </div>

                      <div style="font-size: 15pt; font-weight: 500;">
                        <p>Selamat datang di <a href="#" style="text-decoration:none"><strong>Web Aplikasi Pelayanan Surat Administrasi Desa Online.</strong></a></p>
                      </div><br><br><br>

                      <div style="font-size: 10pt; font-weight: 500;">
                        <b>LETTER-C</b> 2024
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<?php 
  include ('../part/footer.php');
?>