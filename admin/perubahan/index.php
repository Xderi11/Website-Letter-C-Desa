<?php 
include ('../part/akses.php');
include ('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');


$nama_pemilik = "";
$no_persil = "";

// Periksa jika ada data yang ingin diedit
if(isset($_POST['submit'])){
    $nama_pemilik = $_POST['nama_pemilik'];
    $no_persil = $_POST['no_persil'];

    // Query untuk memeriksa apakah data pemilik ada di database
    $query_check = "SELECT * FROM pemilik WHERE nama_pemilik = '$nama_pemilik' AND no_persil = '$no_persil'";
    $result_check = mysqli_query($connect, $query_check);

    if(mysqli_num_rows($result_check) > 0){
        // Data pemilik ditemukan, arahkan ke halaman edit
        header("Location: edit-kepemilikan.php?no_persil=$no_persil");
        exit();
    } else {
        // Data pemilik tidak ditemukan, tampilkan pesan kesalahan
        $error_message = "Nama pemilik dan No Persil tidak sesuai.";
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
              <a href="../penduduk/"><i class="fa fa-circle-notch"></i> Data Letter C</a>
            </li>
          </ul>
        </li>
        <li class="active treeview">
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
              <li class="active">
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
        <h1>Data Perubahan Letter C</h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="active">Data Perubahan Letter C</li>
        </ol>
    </section>
  
    <section class="content">      
        <div class="row">
            <div class="col-md-12">
                <div>
                    <?php 
                    // Tampilkan pesan error jika ada
                    if(isset($error_message)){
                        echo "<div class='alert alert-danger'><center>$error_message</center></div>";
                    }
                    if(isset($_GET['pesan'])){
                        if($_GET['pesan']=="gagal-menambah"){
                            echo "<div class='alert alert-danger'><center>Anda tidak bisa menambah data. Nomor Persil tersebut sudah digunakan.</center></div>";
                        }
                        if($_GET['pesan']=="gagal-mengedit"){
                            echo "<div class='alert alert-danger'><center>Anda tidak bisa mengedit data. Nomor Persil tersebut tidak ditemukan.</center></div>";
                        }
                    }
                    ?>
                </div>

                <br><br>

                <table class="table table-striped table-bordered table-responsive" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><strong>No</strong></th>
                            <th><strong>No Persil</strong></th>
                            <th><strong>Kelas Desa</strong></th>
                            <th><strong>Jenis Tanah</strong></th>
                            <th><strong>Keterangan Tanah</strong></th>
                            <?php 
                            if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
                                echo "<th><strong>Aksi</strong></th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Koneksi database
                        include('../../config/koneksi.php');

                        $no = 1;
                        $query = "SELECT t.no_persil, t.kelas_desa, t.jenis_tanah, t.keterangan_tanah 
                                  FROM tanah t";
                        $result = mysqli_query($connect, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row['no_persil'] . "</td>";
                                echo "<td>" . $row['kelas_desa'] . "</td>";
                                echo "<td>" . $row['jenis_tanah'] . "</td>";

                                // Tampilkan keterangan tanah
                                echo "<td>" . $row['keterangan_tanah'] . "</td>";
                                
                                // Aksi admin jika sesuai level
                                if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
                                    echo "<td>";
                                    echo "<a class='btn btn-success btn-sm' href='detail.php?detail=" . $row['no_persil'] . "'>Detail</a>";

                                    echo "</td>";
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>Tidak ada data</td></tr>";
                        }

                        // Tutup koneksi database
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