<?php
include ('../part/akses.php');
include ('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');

// Ambil no_persil dari query string
$no_persil = isset($_GET['no_persil']) ? $_GET['no_persil'] : '';

// Query untuk mengambil data berdasarkan no_persil
$query = "SELECT k.*, p.tanggal_perubahan, p.sebab_perubahan, p.status_kepemilikan, p.saksi, p.notaris
          FROM kepemilikan_letter_c k
          JOIN pemilik p ON k.id_kepemilikan = p.id_kepemilikan
          WHERE k.no_persil = '$no_persil' AND p.status_kepemilikan = 'Aktif'";
$result = mysqli_query($connect, $query);
$data = mysqli_fetch_assoc($result);

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
                    <li>
                        <a href="../perubahan/"><i class="fa fa-circle-notch"></i> Perubahan</a>
                    </li>
                    <li class="active">
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
        <h1>Detail Kepemilikan Letter C</h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="../kepemilikan/"><i class="fa fa-list"></i> Kepemilikan</a></li>
            <li class="active">Detail</li>
        </ol>
    </section>
  
    <section class="content">      
        <div class="row">
            <div class="col-md-12">
                <?php if ($data): ?>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">NIK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo isset($data['nik']) ? htmlspecialchars($data['nik']) : ''; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Pemilik</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo isset($data['nama_pemilik']) ? htmlspecialchars($data['nama_pemilik']) : ''; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">No Persil</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo isset($data['no_persil']) ? htmlspecialchars($data['no_persil']) : ''; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tanggal Penerbitan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo isset($data['tanggal']) ? htmlspecialchars($data['tanggal']) : ''; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Keterangan Tanah</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo isset($data['keterangan_tanah']) ? htmlspecialchars($data['keterangan_tanah']) : ''; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tanggal Perubahan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo isset($data['tanggal_perubahan']) ? htmlspecialchars($data['tanggal_perubahan']) : ''; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Sebab Perubahan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo isset($data['sebab_perubahan']) ? htmlspecialchars($data['sebab_perubahan']) : ''; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Saksi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo isset($data['saksi']) ? htmlspecialchars($data['saksi']) : ''; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Notaris</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo isset($data['notaris']) ? htmlspecialchars($data['notaris']) : ''; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status Kepemilikan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo isset($data['status_kepemilikan']) ? htmlspecialchars($data['status_kepemilikan']) : ''; ?>" readonly>
                            </div>
                        </div>
                    </form>
                    <a href="index.php" class="btn btn-primary">Kembali</a>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <center>Data tidak ditemukan atau tidak aktif.</center>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<?php include ('../part/footer.php'); ?>
