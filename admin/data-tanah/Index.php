<?php 
  include ('../part/akses.php');
  include ('../part/header.php');
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
        <li class="active treeview">
          <a href="#">
            <i class="fas fa-database"></i> <span>&nbsp;&nbsp;Data Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active">
              <a href="../data-tanah/"><i class="fa fa-circle-notch"></i> Data Tanah</a>
            </li>
            <li>
              <a href="../penduduk/"><i class="fa fa-circle-notch"></i> Data Letter C</a>
            </li>
          </ul>
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
    <h1>Data Tanah</h1>
    <ol class="breadcrumb">
      <li><a href="../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
      <li class="active">Data Tanah</li>
    </ol>
  </section>
  
  <section class="content">      
    <div class="row">
      <div class="col-md-12">
        <!-- Pesan Kesalahan -->
        <?php 
          if(isset($_GET['pesan'])){
            if($_GET['pesan']=="gagal-menambah"){
              echo "<div class='alert alert-danger'><center>Anda tidak bisa menambah data. Nomor Persil tersebut sudah digunakan.</center></div>";
            }
            if($_GET['pesan']=="gagal-menghapus"){
              echo "<div class='alert alert-danger'><center>Anda tidak bisa menghapus data tersebut.</center></div>";
            }
          }
        ?>

        <!-- Tombol Aksi -->
        <?php 
          if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
        ?>
        <a class="btn btn-success btn-md" href='tambah-data-tanah.php'><i class="fas fa-plus"></i> Tambah Data Tanah</a>
        <a target="_blank" class="btn btn-info btn-md" href='export-penduduk.php'><i class="fas fa-file-export"></i> Export .XLS</a>
        <?php 
          }
        ?>
        <br><br>

        <!-- Tabel Data Tanah -->
        <table class="table table-striped table-bordered table-responsive" id="data-table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th><strong>No</strong></th>
              <th><strong>No Persil</strong></th>
              <th><strong>Kelas Desa</strong></th>
              <th><strong>Luas Milik</strong></th>
              <th><strong>Jenis Tanah</strong></th>
              <th><strong>Pajak Bumi</strong></th>
              <th><strong>Keterangan Tanah</strong></th>
              <?php 
                if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
              ?>
              <th><strong>Aksi</strong></th>
              <?php  
                }
              ?>
            </tr>
          </thead>
          <tbody>
            <?php
              include ('../../config/koneksi.php');
              $no = 1;
              $qTampil = mysqli_query($connect, "SELECT * FROM tanah");
              while ($row = mysqli_fetch_assoc($qTampil)) {   
            ?>
            <tr>
              <td><?php echo $no++; ?></td>
              <td style="text-transform: capitalize;"><?php echo $row['no_persil']; ?></td>
              <td style="text-transform: capitalize;"><?php echo $row['kelas_desa']; ?></td>
              <td style="text-transform: capitalize;"><?php echo $row['luas_milik']; ?></td>
              <td style="text-transform: capitalize;"><?php echo $row['jenis_tanah']; ?></td>
              <td>Rp. <?php echo number_format($row['pajak_bumi'], 0, ','); ?></td>
              <td style="text-transform: capitalize;"><?php echo $row['keterangan_tanah']; ?></td>
              <?php 
                if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
              ?>
              <td>
                <a class="btn btn-success btn-sm" href='edit-tanah.php?id=<?php echo $row['id_tanah']; ?>'><i class="fa fa-edit"></i></a>
                <a class="btn btn-danger btn-sm" href='hapus-data-tanah.php?id=<?php echo $row['id_tanah']; ?>' onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i></a>
              </td>
              <?php  
                }
              ?>
            </tr>
            <?php
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<?php 
include ('../part/footer.php');
?>