<?php
include ('../part/akses.php');
include ('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');

// Deklarasi variabel
$nik = "";
$nama_pemilik = "";
$no_persil = "";
$keterangan_tanah = "";
$tanggal_perubahan = "";
$sebab_perubahan = "";
$status_kepemilikan = "";
$saksi = "";
$notaris = "";
$alamat_pemilik = "";
$kelas_desa = "";
$luas_milik = "";
$jenis_tanah = "";
$tanggal = "";
$pajak_bumi = "";
$error_message = "";
$success_message = "";

// Ambil data dari parameter URL
if (isset($_GET['nik']) && isset($_GET['no_persil'])) {
    $nik = $_GET['nik'];
    $no_persil = $_GET['no_persil'];

    // Query untuk mendapatkan data dari tabel perubahan berdasarkan nik dan no_persil
    $query_get_data = "SELECT alamat_pemilik, kelas_desa, luas_milik, jenis_tanah, tanggal, pajak_bumi, keterangan_tanah, nama_pemilik, tanggal_perubahan, sebab_perubahan, status_kepemilikan, saksi, notaris 
                       FROM perubahan WHERE nik = '$nik' AND no_persil = '$no_persil'";
    $result_get_data = mysqli_query($connect, $query_get_data);

    if (!$result_get_data) {
        die("Query Error: " . mysqli_error($connect));
    }

    if (mysqli_num_rows($result_get_data) > 0) {
        $row = mysqli_fetch_assoc($result_get_data);
        $alamat_pemilik = $row['alamat_pemilik'];
        $kelas_desa = $row['kelas_desa'];
        $luas_milik = $row['luas_milik'];
        $jenis_tanah = $row['jenis_tanah'];
        $tanggal = $row['tanggal'];
        $pajak_bumi = $row['pajak_bumi'];
        $keterangan_tanah = $row['keterangan_tanah'];
        $nama_pemilik = $row['nama_pemilik'];
        $tanggal_perubahan = $row['tanggal_perubahan'];
        $sebab_perubahan = $row['sebab_perubahan'];
        $status_kepemilikan = $row['status_kepemilikan'];
        $saksi = $row['saksi'];
        $notaris = $row['notaris'];
    } else {
        $error_message = "Data tidak ditemukan.";
    }
}


// Proses form submission
if (isset($_POST['submit'])) {
    // Ambil data dari POST
    $nik = $_POST['nik'];
    $nama_pemilik = $_POST['nama_pemilik'];
    $no_persil = $_POST['no_persil'];
    $alamat_pemilik = $_POST['alamat_pemilik'];
    $kelas_desa = $_POST['kelas_desa'];
    $luas_milik = $_POST['luas_milik'];
    $jenis_tanah = $_POST['jenis_tanah'];
    $tanggal = $_POST['tanggal'];
    $pajak_bumi = $_POST['pajak_bumi'];
    $keterangan_tanah = $_POST['keterangan_tanah'];
    $tanggal_perubahan = $_POST['tanggal_perubahan'];
    $sebab_perubahan = $_POST['sebab_perubahan'];
    $status_kepemilikan = $_POST['status_kepemilikan'];
    $saksi = $_POST['saksi'];
    $notaris = $_POST['notaris'];

    // echo '<pre>'; print_r($_POST); echo '</pre>'; exit();

    // Query untuk memasukkan data ke tabel perubahan
    $query_insert = "INSERT INTO perubahan (nik, nama_pemilik, no_persil, alamat_pemilik, kelas_desa, luas_milik, jenis_tanah, tanggal, pajak_bumi, keterangan_tanah, tanggal_perubahan, sebab_perubahan, status_kepemilikan, saksi, notaris)
                     VALUES ('$nik', '$nama_pemilik', '$no_persil', '$alamat_pemilik', '$kelas_desa', '$luas_milik', '$jenis_tanah', '$tanggal', '$pajak_bumi', '$keterangan_tanah', '$tanggal_perubahan', '$sebab_perubahan', '$status_kepemilikan', '$saksi', '$notaris')";
    $result_insert = mysqli_query($connect, $query_insert);

    if (!$result_insert) {
        die("Query Error: " . mysqli_error($connect));
    } else {
        // Jika status_kepemilikan adalah aktif, masukkan data ke tabel pemilik
        if ($status_kepemilikan == 'aktif') {
            $query_insert_pemilik = "INSERT INTO pemilik (nik, nama_pemilik, no_persil, alamat_pemilik, kelas_desa, luas_milik, jenis_tanah, keterangan_tanah, tanggal, pajak_bumi, status_kepemilikan)
                                     VALUES ('$nik', '$nama_pemilik', '$no_persil', '$alamat_pemilik', '$kelas_desa', '$luas_milik', '$jenis_tanah', '$tanggal', '$keterangan_tanah', '$pajak_bumi', '$status_kepemilikan')";
            $result_insert_pemilik = mysqli_query($connect, $query_insert_pemilik);

            if (!$result_insert_pemilik) {
                die("Query Error: " . mysqli_error($connect));
            }
        }

        // Redirect atau tampilkan pesan sukses
        header("Location: index.php?message=Data berhasil disimpan.");
        exit();
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
                    <li >
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
        <h1>Tambah Perubahan Letter C</h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="index.php">Data Perubahan Letter C</a></li>
            <li class="active">Tambah Perubahan Letter C</li>
        </ol>
    </section>
  
    <section class="content">
        <div class="row">
            <div class="col-md-12">
              
                <div>
                    <!-- Tampilkan pesan error jika ada -->
                    <?php 
                        if (isset($error_message) && $error_message !== ""){
                            echo "<div class='alert alert-danger'><center>$error_message</center></div>";
                        }
                        if (isset($success_message) && $success_message !== ""){
                            echo "<div class='alert alert-success'><center>$success_message</center></div>";
                        }
                    ?>
                </div>

                <!-- Form untuk menambah data perubahan -->
                <form action="simpan-perubahan.php" method="POST" class="form">
                    <div class="form-group">
                        <label for="nik">NIK:</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo htmlspecialchars($nik); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="nama_pemilik">Nama Pemilik:</label>
                        <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" value="<?php echo htmlspecialchars($nama_pemilik); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="no_persil">No Persil:</label>
                        <input type="text" class="form-control" id="no_persil" name="no_persil" value="<?php echo htmlspecialchars($no_persil); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="alamat_pemilik">Alamat Pemilik:</label>
                        <input type="text" class="form-control" id="alamat_pemilik" name="alamat_pemilik" value="<?php echo htmlspecialchars($alamat_pemilik); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="kelas_desa">Kelas Desa:</label>
                        <input type="text" class="form-control" id="kelas_desa" name="kelas_desa" value="<?php echo htmlspecialchars($kelas_desa); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="luas_milik">Luas Milik:</label>
                        <input type="text" class="form-control" id="luas_milik" name="luas_milik" value="<?php echo htmlspecialchars($luas_milik); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_tanah">Jenis Tanah:</label>
                        <input type="text" class="form-control" id="jenis_tanah" name="jenis_tanah" value="<?php echo htmlspecialchars($jenis_tanah); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal:</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($tanggal); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="pajak_bumi">Pajak Bumi:</label>
                        <input type="text" class="form-control" id="pajak_bumi" name="pajak_bumi" value="<?php echo htmlspecialchars($pajak_bumi); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_tanah">Keterangan Tanah:</label>
                        <input type="text" class="form-control" id="keterangan_tanah" name="keterangan_tanah" value="<?php echo htmlspecialchars($keterangan_tanah); ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_perubahan">Tanggal Perubahan:</label>
                        <input type="date" class="form-control" id="tanggal_perubahan" name="tanggal_perubahan" value="<?php echo htmlspecialchars($tanggal_perubahan); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="sebab_perubahan">Sebab Perubahan:</label>
                        <select class="form-control" id="sebab_perubahan" name="sebab_perubahan" required>
                            <option value="" disabled>Pilih Sebab Perubahan</option>
                            <option value="jual/beli" <?php echo ($sebab_perubahan == 'jual/beli') ? 'selected' : ''; ?>>Jual/Beli</option>
                            <option value="warisan" <?php echo ($sebab_perubahan == 'warisan') ? 'selected' : ''; ?>>Warisan</option>
                            <option value="hibah" <?php echo ($sebab_perubahan == 'hibah') ? 'selected' : ''; ?>>Hibah</option>
                            <option value="wakaf" <?php echo ($sebab_perubahan == 'wakaf') ? 'selected' : ''; ?>>Wakaf</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_kepemilikan">Status Kepemilikan:</label>
                        <select class="form-control" id="status_kepemilikan" name="status_kepemilikan" required>
                            <option value="" disabled>Pilih Status Kepemilikan</option>
                            <option value="aktif" <?php echo ($status_kepemilikan == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                            <option value="tidak aktif" <?php echo ($status_kepemilikan == 'tidak aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="saksi">Saksi:</label>
                        <input type="text" class="form-control" id="saksi" name="saksi" value="<?php echo htmlspecialchars($saksi); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="notaris">Notaris:</label>
                        <input type="text" class="form-control" id="notaris" name="notaris" value="<?php echo htmlspecialchars($notaris); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                </form>
              
            </div>
        </div>
    </section>
</div>

<?php
include ('../part/footer.php');
?>
