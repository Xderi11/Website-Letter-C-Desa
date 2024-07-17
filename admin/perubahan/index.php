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
            <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Surat</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="../surat/buat_surat/"><i class="fa fa-circle-notch"></i> Buat Surat</a>
            </li>
            <li>
              <a href="../surat/permintaan_surat/"><i class="fa fa-circle-notch"></i> Permintaan Surat</a>
            </li>
            <li>
              <a href="../surat/surat_selesai/"><i class="fa fa-circle-notch"></i> Surat Selesai</a>
            </li>
          </ul>
        </li>
        <?php 
          }
        ?>
        <li>
          <a href="../laporan/"><i class="fas fa-chart-line"></i> <span>&nbsp;&nbsp;Laporan</span></a>
        </li>
      </ul>
    </section>
  </aside>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Kepemilikan Letter C</h1>
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

                <!-- Form untuk memasukkan nama pemilik dan no persil -->
                <form action="index.php" method="POST" class="form-inline">
                    <div class="form-group">
                        <label for="nama_pemilik">Nama:</label>
                        <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" value="<?php echo $nama_pemilik; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_persil">No Persil:</label>
                        <input type="text" class="form-control" id="no_persil" name="no_persil" value="<?php echo $no_persil; ?>" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Cek Data</button>
                </form>

                <br><br>

                <table class="table table-striped table-bordered table-responsive" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><strong>No</strong></th>
                            <th><strong>Nama Pemilik</strong></th>
                            <th><strong>No Persil</strong></th>
                            <th><strong>Tanggal Penerbitan</strong></th>
                            <th><strong>Keterangan Tanah</strong></th>
                            <th><strong>Tanggal Perubahan</strong></th>
                            <th><strong>Sebab Perubahan</strong></th>
                            <th><strong>Status Kepemilikan</strong></th>
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
                        $query = "SELECT k.*, p.tanggal_perubahan, p.sebab_perubahan, p.status_kepemilikan 
                                  FROM kepemilikan_letter_c k
                                  LEFT JOIN pemilik p ON k.id_kepemilikan = p.id_kepemilikan";
                        $result = mysqli_query($connect, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row['nama_pemilik'] . "</td>";
                                echo "<td>" . $row['no_persil'] . "</td>";
                                echo "<td>" . date('d F Y', strtotime($row['tanggal'])) . "</td>";
                                
                                // Tampilkan keterangan tanah
                                echo "<td>" . $row['keterangan_tanah'] . "</td>";
                                echo "<td>" . (isset($row['tanggal_perubahan']) ? date('d F Y', strtotime($row['tanggal_perubahan'])) : '-') . "</td>";
                                echo "<td>" . $row['sebab_perubahan'] . "</td>";
                                echo "<td>" . $row['status_kepemilikan'] . "</td>";
                                
                                // Aksi admin jika sesuai level
                                if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
                                    echo "<td>";
                                    echo "<a class='btn btn-success btn-sm' href='index.php?edit=" . $row['no_persil'] . "'><i class='fa fa-edit'></i></a>";
                                    echo "<a class='btn btn-danger btn-sm' href='hapus-kepemilikan.php?id=" . $row['id_kepemilikan'] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\"><i class='fa fa-trash'></i></a>";
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