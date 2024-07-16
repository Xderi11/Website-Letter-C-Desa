<?php 
include ('../part/akses.php');
include ('../../config/koneksi.php');
include ('../part/header.php');

$id = $_GET['id'];
$qCek = mysqli_query($connect,"SELECT * FROM tanah WHERE id_tanah='$id'");
$row = mysqli_fetch_array($qCek);

if (!$row) {
  echo "Data tidak ditemukan.";
  exit;
}


// Inisialisasi variabel untuk alert
$alert_message = '';
$alert_class = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_persil = $_POST['fno_persil'];
    $kelas_desa = $_POST['fkelas_desa'];
    $luas_milik = $_POST['fluas_milik'];
    $jenis_tanah = $_POST['fjenis_tanah'];
    $pajak_bumi = $_POST['fpajak_bumi'];
    $keterangan_tanah = $_POST['fketerangan_tanah'];

    // Query untuk memeriksa apakah nomor persil sudah ada di database (kecuali data yang sedang diedit)
    $queryCheck = "SELECT id_tanah FROM tanah WHERE no_persil = '$no_persil' AND id_tanah != $id";
    $resultCheck = mysqli_query($connect, $queryCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
        // Jika nomor persil sudah ada di database (selain untuk data yang sedang diedit)
        $alert_message = "Nomor persil sudah ada di database.";
        $alert_class = "alert-danger";
    } else {
        // Query untuk update data
        $query = "UPDATE tanah SET 
                  no_persil = '$no_persil', 
                  kelas_desa = '$kelas_desa', 
                  luas_milik = '$luas_milik', 
                  jenis_tanah = '$jenis_tanah', 
                  pajak_bumi = '$pajak_bumi', 
                  keterangan_tanah = '$keterangan_tanah' 
                  WHERE id_tanah = $id";

        if (mysqli_query($connect, $query)) {
            mysqli_close($connect);
            $alert_message = "Data tanah berhasil diubah.";
            $alert_class = "alert-success";

            // Script JavaScript untuk pindah ke halaman index.php setelah 2 detik
            echo "<script>
                    setTimeout(function() {
                        window.location.href = '../data-tanah/';
                    }, 0);
                  </script>";
        } else {
            $alert_message = "Ada masalah dengan input data.";
            $alert_class = "alert-danger";
        }
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
    <!-- Breadcrumb header -->
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fas fa-edit"></i> Edit Data Tanah</h3>
          </div>
          <div class="box-body">
            <!-- Form edit tanah -->
            <?php if (!empty($alert_message)): ?>
              <div class="alert <?php echo $alert_class; ?>">
                <center><?php echo $alert_message; ?></center>
              </div>
            <?php endif; ?>
            
            <form class="form-horizontal" method="post" action="">
              <div class="col-md-6">
                <input type="hidden" name="id_tanah" value="<?php echo $row['id_tanah']; ?>">
                <div class="form-group">
                  <label class="col-sm-4 control-label">No Persil</label>
                  <div class="col-sm-8">
                    <input type="number" name="fno_persil" class="form-control" placeholder="No Persil" value="<?php echo $row['no_persil']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Kelas Desa</label>
                  <div class="col-sm-8">
                    <input type="text" name="fkelas_desa" class="form-control" placeholder="Kelas Desa" value="<?php echo $row['kelas_desa']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Luas Lahan</label>
                  <div class="col-sm-8">
                    <input type="text" name="fluas_milik" class="form-control" placeholder="Luas Lahan" value="<?php echo $row['luas_milik']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Jenis Tanah</label>
                  <div class="col-sm-8">
                    <input type="text" name="fjenis_tanah" class="form-control" placeholder="Jenis Tanah" value="<?php echo $row['jenis_tanah']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Pajak Bumi</label>
                  <div class="col-sm-8">
                    <input type="text" name="fpajak_bumi" class="form-control" placeholder="Pajak Bumi" value="<?php echo $row['pajak_bumi']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Keterangan Tanah</label>
                  <div class="col-sm-8">
                    <input type="text" name="fketerangan_tanah" class="form-control" placeholder="Keterangan Tanah" value="<?php echo $row['keterangan_tanah']; ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-8 col-sm-offset-4">
                    <div class="pull-right">
                      <!-- Tombol "Batal" dengan skrip JavaScript untuk kembali ke halaman index.php -->
                      <button type="button" class="btn btn-default" onclick="window.location.href='../data-tanah/';">Batal</button>
                      <input type="submit" name="submit" class="btn btn-info" value="Submit">
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
include ('../part/footer.php');
?>