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
        <li class="active">
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
                <a href="../perubahan/"><i class="fa fa-circle-notch"></i> Perubahan</a>
              </li>
              <li>
                <a href="../kepemilikan/"><i class="fa fa-circle-notch"></i> Kepemilikan</a>
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
              <a href="../laporan-kepemilikan/"><i class="fa fa-circle-notch"></i> Kepemilikan</a>
            </li>
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
    <h1>Data Letter C</h1>
    <ol class="breadcrumb">
      <li><a href="../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
      <li class="active">Data Letter C</li>
    </ol>
  </section>
  
  <section class="content">      
    <div class="row">
      <div class="col-md-12">
        <div>
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
        </div>
        
        <?php 
          if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
        ?>
        <a class="btn btn-success btn-md" href='tambah-penduduk.php'><i class="fa fa-user-plus"></i> Tambah Data Letter C</a>
        <?php 
          }
        ?>
        
        <br><br>
        
        <table class="table table-striped table-bordered table-responsive" id="data-table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th><strong>No</strong></th>
              <th><strong>NIK</strong></th>
              <th><strong>Nama Pemilik</strong></th>
              <th><strong>No Persil</strong></th>
              <th><strong>Luas Milik</strong></th>
              <th><strong>Jenis Tanah</strong></th>
              <th><strong>Tanggal Penerbitan</strong></th>
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
$query = "SELECT * FROM kepemilikan_letter_c";
$result = mysqli_query($connect, $query);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . $row['nik'] . "</td>";
    echo "<td>" . $row['nama_pemilik'] . "</td>";
    echo "<td>" . $row['no_persil'] . "</td>";
    echo "<td>" . $row['luas_milik'] . "</td>";
    echo "<td>" . $row['jenis_tanah'] . "</td>";
    echo "<td>" . date('d F Y', strtotime($row['tanggal'])) . "</td>";
    echo "<td>" . $row['keterangan_tanah'] . "</td>";
    
    // Aksi admin jika sesuai level
    if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
      echo "<td>";
      echo "<a class='btn btn-success btn-sm' href='edit-penduduk.php?id=" . $row['id_kepemilikan'] . "'><i class='fa fa-edit'></i></a>";
      echo "<a class='btn btn-danger btn-sm' href='hapus-penduduk.php?id=" . $row['id_kepemilikan'] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\"><i class='fa fa-trash'></i></a>";
      echo "</td>";
    }
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='10'>Tidak ada data</td></tr>";
}

mysqli_close($connect);
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
