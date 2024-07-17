<?php 
include ('../part/akses.php');
include ('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');

// Inisialisasi variabel
$id_kepemilikan = "";
$nama_pemilik = "";
$no_persil = "";
$tanggal = "";
$keterangan_tanah = "";
$tanggal_perubahan = "";
$sebab_perubahan = "";
$status_kepemilikan = "";

// Periksa jika ada parameter no_persil yang dikirim
if(isset($_GET['no_persil'])){
    $no_persil = $_GET['no_persil'];
    
    // Query untuk mengambil data dari tabel pemilik berdasarkan no_persil
    $query = "SELECT k.id_kepemilikan, k.nama_pemilik, k.no_persil, k.tanggal, k.keterangan_tanah, p.tanggal_perubahan, p.sebab_perubahan, p.status_kepemilikan 
              FROM kepemilikan_letter_c k
              LEFT JOIN pemilik p ON k.id_kepemilikan = p.id_kepemilikan
              WHERE k.no_persil = '$no_persil'";
    $result = mysqli_query($connect, $query);
    
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $id_kepemilikan = $data['id_kepemilikan'];
        $nama_pemilik = $data['nama_pemilik'];
        $no_persil = $data['no_persil'];
        $tanggal = $data['tanggal'];
        $keterangan_tanah = $data['keterangan_tanah'];
        $tanggal_perubahan = $data['tanggal_perubahan'];
        $sebab_perubahan = $data['sebab_perubahan'];
        $status_kepemilikan = $data['status_kepemilikan'];
    } else {
        $error_message = "Data tidak ditemukan.";
    }
}

// Periksa jika ada data yang disubmit
if(isset($_POST['submit'])){
    $tanggal_perubahan = $_POST['tanggal_perubahan'];
    $sebab_perubahan = $_POST['sebab_perubahan'];
    $status_kepemilikan = $_POST['status_kepemilikan'];

    // Query untuk mengupdate data pemilik
    $query_update = "UPDATE pemilik SET tanggal_perubahan='$tanggal_perubahan', sebab_perubahan='$sebab_perubahan', status_kepemilikan='$status_kepemilikan' 
                     WHERE id_kepemilikan='$id_kepemilikan'";
    $result_update = mysqli_query($connect, $query_update);
    
    if($result_update){
        header("Location: index.php?pesan=berhasil-mengedit");
        exit();
    } else {
        $error_message = "Gagal mengupdate data.";
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
                    <li class="active">
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
        <h1>Edit Data Kepemilikan Letter C</h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="index.php">Data Letter C</a></li>
            <li class="active">Edit Data Kepemilikan</li>
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
                        if($_GET['pesan']=="berhasil-mengedit"){
                            echo "<div class='alert alert-success'><center>Data berhasil diupdate.</center></div>";
                        }
                    }
                    ?>
                </div>

                <!-- Form untuk mengedit data -->
                <form action="edit-kepemilikan.php?no_persil=<?php echo $no_persil; ?>" method="POST" class="form-horizontal">
                    <div class="form-group">
                        <label for="nama_pemilik" class="col-sm-2 control-label">Nama Pemilik:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" value="<?php echo $nama_pemilik; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_persil" class="col-sm-2 control-label">No Persil:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_persil" name="no_persil" value="<?php echo $no_persil; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal" class="col-sm-2 control-label">Tanggal:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?php echo date('d F Y', strtotime($tanggal)); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_tanah" class="col-sm-2 control-label">Keterangan Tanah:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keterangan_tanah" name="keterangan_tanah" value="<?php echo $keterangan_tanah; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_perubahan" class="col-sm-2 control-label">Tanggal Perubahan:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggal_perubahan" name="tanggal_perubahan" value="<?php echo $tanggal_perubahan; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sebab_perubahan" class="col-sm-2 control-label">Sebab Perubahan:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="sebab_perubahan" name="sebab_perubahan" value="<?php echo $sebab_perubahan; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_kepemilikan" class="col-sm-2 control-label">Status Kepemilikan:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="status_kepemilikan" name="status_kepemilikan" required>
                                <option value="aktif" <?php if($status_kepemilikan == 'aktif') echo 'selected'; ?>>Aktif</option>
                                <option value="tidak aktif" <?php if($status_kepemilikan == 'tidak aktif') echo 'selected'; ?>>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" name="submit" class="btn btn-primary">Update Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<?php 
include ('../part/footer.php');
?>
