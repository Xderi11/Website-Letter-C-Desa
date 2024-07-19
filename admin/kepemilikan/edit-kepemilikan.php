<?php 
include ('../part/akses.php');
include ('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');

// Inisialisasi variabel
$id_kepemilikan = "";
$nama_pemilik = "";
$alamat_pemilik = "";
$no_persil = "";
$kelas_desa = "";
$luas_milik = "";
$jenis_tanah = "";
$tanggal = "";
$pajak_bumi = "";
$keterangan_tanah = "";
$tanggal_perubahan = "";
$sebab_perubahan = "";
$status_kepemilikan = "";

// Periksa jika ada parameter no_persil yang dikirim
if(isset($_GET['no_persil'])){
    $no_persil = $_GET['no_persil'];
    
    // Query untuk mengambil data dari tabel kepemilikan_letter_c dan pemilik berdasarkan no_persil
    $query = "SELECT k.id_kepemilikan, k.nama_pemilik, k.alamat_pemilik, k.no_persil, k.kelas_desa, k.luas_milik, k.jenis_tanah, k.tanggal, k.pajak_bumi, k.keterangan_tanah, 
              p.tanggal_perubahan, p.sebab_perubahan, p.status_kepemilikan 
              FROM kepemilikan_letter_c k
              LEFT JOIN pemilik p ON k.id_kepemilikan = p.id_kepemilikan
              WHERE k.no_persil = '$no_persil'";
    $result = mysqli_query($connect, $query);
    
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $id_kepemilikan = $data['id_kepemilikan'];
        $nama_pemilik = $data['nama_pemilik'];
        $alamat_pemilik = $data['alamat_pemilik'];
        $no_persil = $data['no_persil'];
        $kelas_desa = $data['kelas_desa'];
        $luas_milik = $data['luas_milik'];
        $jenis_tanah = $data['jenis_tanah'];
        $tanggal = $data['tanggal'];
        $pajak_bumi = $data['pajak_bumi'];
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

    // Mulai transaksi
    mysqli_begin_transaction($connect);

    // Query untuk memasukkan data lengkap ke tabel perubahan
    $query_insert_perubahan = "INSERT INTO perubahan (id_kepemilikan, nama_pemilik, alamat_pemilik, no_persil, kelas_desa, luas_milik, jenis_tanah, tanggal, pajak_bumi, keterangan_tanah, 
                               tanggal_perubahan, sebab_perubahan, status_kepemilikan) 
                               VALUES ('$id_kepemilikan', '$nama_pemilik', '$alamat_pemilik', '$no_persil', '$kelas_desa', '$luas_milik', '$jenis_tanah', '$tanggal', '$pajak_bumi', '$keterangan_tanah', 
                               '$tanggal_perubahan', '$sebab_perubahan', '$status_kepemilikan')";
    $result_insert_perubahan = mysqli_query($connect, $query_insert_perubahan);

    if($result_insert_perubahan){
        if($status_kepemilikan == 'Aktif'){
            // Query untuk mengupdate data pemilik jika status kepemilikan aktif
            $query_update_pemilik = "UPDATE pemilik SET tanggal_perubahan='$tanggal_perubahan', sebab_perubahan='$sebab_perubahan', status_kepemilikan='$status_kepemilikan' 
                                     WHERE id_kepemilikan='$id_kepemilikan'";
            $result_update_pemilik = mysqli_query($connect, $query_update_pemilik);
            
            if($result_update_pemilik){
                // Commit transaksi
                mysqli_commit($connect);
                header("Location: index.php?pesan=berhasil-mengedit");
                exit();
            } else {
                // Rollback transaksi jika ada error
                mysqli_rollback($connect);
                $error_message = "Gagal mengupdate data.";
            }
        } else if($status_kepemilikan == 'Tidak Aktif'){
            // Query untuk menghapus data pemilik jika status kepemilikan tidak aktif
            $query_delete_pemilik = "DELETE FROM pemilik WHERE id_kepemilikan='$id_kepemilikan'";
            $result_delete_pemilik = mysqli_query($connect, $query_delete_pemilik);
            
            if($result_delete_pemilik){
                // Commit transaksi
                mysqli_commit($connect);
                header("Location: index.php?pesan=berhasil-mengedit");
                exit();
            } else {
                // Rollback transaksi jika ada error
                mysqli_rollback($connect);
                $error_message = "Gagal menghapus data.";
            }
        }
    } else {
        // Rollback transaksi jika ada error
        mysqli_rollback($connect);
        $error_message = "Gagal memasukkan data ke tabel perubahan.";
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
                <form action="" method="POST">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Informasi Kepemilikan</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="nama_pemilik">Nama Pemilik</label>
                                <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" value="<?php echo $nama_pemilik; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="alamat_pemilik">Alamat Pemilik</label>
                                <input type="text" class="form-control" id="alamat_pemilik" name="alamat_pemilik" value="<?php echo $alamat_pemilik; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="alamat_pemilik">No Persil</label>
                                <input type="text" class="form-control" id="no persil" name="no_persil" value="<?php echo $no_persil; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="kelas_desa">Kelas Desa</label>
                                <input type="text" class="form-control" id="kelas_desa" name="kelas_desa" value="<?php echo $kelas_desa; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="luas_milik">Luas Milik</label>
                                <input type="text" class="form-control" id="luas_milik" name="luas_milik" value="<?php echo $luas_milik; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="jenis_tanah">Jenis Tanah</label>
                                <input type="text" class="form-control" id="jenis_tanah" name="jenis_tanah" value="<?php echo $jenis_tanah; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $tanggal; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="pajak_bumi">Pajak Bumi</label>
                                <input type="text" class="form-control" id="pajak_bumi" name="pajak_bumi" value="<?php echo $pajak_bumi; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="pajak_bumi">Keterangan Tanah</label>
                                <input type="text" class="form-control" id="keterangan_tanah" name="keterangan_tanah" value="<?php echo $keterangan_tanah; ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Perubahan Data Kepemilikan</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="tanggal_perubahan">Tanggal Perubahan</label>
                                <input type="date" class="form-control" id="tanggal_perubahan" name="tanggal_perubahan" required>
                            </div>
                            <div class="form-group">
                                <label for="sebab_perubahan">Sebab Perubahan</label>
                                <input type="text" class="form-control" id="sebab_perubahan" name="sebab_perubahan" required>
                            </div>
                            <div class="form-group">
                                <label for="status_kepemilikan" class="col-sm-2 control-label">Status Kepemilikan:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="status_kepemilikan" name="status_kepemilikan" required>
                                        <option value="Aktif" <?php echo ($status_kepemilikan == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="Tidak Aktif" <?php echo ($status_kepemilikan == 'Tidak Aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
</div>

<?php include ('../part/footer.php'); ?>