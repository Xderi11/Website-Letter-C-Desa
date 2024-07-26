<?php
include ('../part/akses.php');
include ('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');

// Deklarasi variabel
$nik = "";
$no_persil = "";
$error_message = "";
$data_perubahan = null;
$form_submitted = false;

// Proses form submission
if(isset($_POST['submit'])){
    $form_submitted = true; 
    $nik = $_POST['nik'];
    $no_persil = $_POST['no_persil'];

    // Query untuk memeriksa apakah data perubahan ada di database
    $query_check = "SELECT * FROM perubahan WHERE nik = '$nik' AND no_persil = '$no_persil'";
    $result_check = mysqli_query($connect, $query_check);

    if(!$result_check) {
        die("Query Error: " . mysqli_error($connect));
    }

    if(mysqli_num_rows($result_check) > 0){
        // Data ditemukan, simpan data untuk dikirim ke halaman berikutnya
        $row = mysqli_fetch_assoc($result_check);
        $nama_pemilik = $row['nama_pemilik'];
        $data_perubahan = [
            'tanggal_perubahan' => $row['tanggal_perubahan'],
            'sebab_perubahan' => $row['sebab_perubahan'],
            'saksi' => $row['saksi'],
            'notaris' => $row['notaris'],
            'status_kepemilikan' => $row['status_kepemilikan']
        ];

        // Redirect ke halaman tambah-perubahan.php dengan data yang diperlukan
        header("Location: tambah-perubahan.php?nik=" . urlencode($nik) . "&no_persil=" . urlencode($no_persil));
        exit();
    } else {
        // Data tidak ditemukan, tampilkan pesan kesalahan
        $error_message = "NIK dan No Persil tidak sesuai.";
    }
}
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
        <li class="active treeview">
            <a href="#">
              <i class="fas fa-exchange-alt"></i> <span>Transaksi</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active">
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
                    <!-- Tampilkan pesan error jika ada dan form sudah disubmit -->
                    <?php 
                        if($form_submitted && isset($error_message) && $error_message !== ""){
                            echo "<div class='alert alert-danger'><center>$error_message</center></div>";
                        }
                    ?>
                </div>
                
                <!-- Form untuk memasukkan NIK dan No Persil -->
                <form action="index.php" method="POST" class="form-inline">
                    <div class="form-group">
                        <label for="nik">NIK:</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo htmlspecialchars($nik); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_persil">No Persil:</label>
                        <input type="text" class="form-control" id="no_persil" name="no_persil" value="<?php echo htmlspecialchars($no_persil); ?>" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Cek Data</button>
                </form>

                <br><br>

                <!-- Tabel untuk menampilkan semua data perubahan -->
                <table class="table table-striped table-bordered table-responsive" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><strong>No.</strong></th>
                            <th><strong>NIK</strong></th>
                            <th><strong>Nama Pemilik</strong></th>
                            <th><strong>No Persil</strong></th>
                            <th><strong>Keterangan Tanah</strong></th>
                            <th><strong>Tanggal Perubahan</strong></th>
                            <th><strong>Sebab Perubahan</strong></th>
                            <th><strong>Saksi</strong></th>
                            <th><strong>Notaris</strong></th>
                            <th><strong>Status Kepemilikan</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Query untuk mengambil data perubahan dengan status kepemilikan yang tidak null
                    $query = "SELECT * FROM perubahan WHERE status_kepemilikan IS NOT NULL";
                    $result = mysqli_query($connect, $query);
                    if(!$result) {
                        die("Query Error: " . mysqli_error($connect));
                    }
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>" . $no . "</td>";
                        echo "<td>" . htmlspecialchars($row['nik']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_pemilik']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['no_persil']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['keterangan_tanah']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tanggal_perubahan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['sebab_perubahan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['saksi']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['notaris']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status_kepemilikan']) . "</td>";

                        echo "</tr>";
                        $no++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php 
// Tutup koneksi database di akhir file
mysqli_close($connect);
include('../part/footer.php');
?>
