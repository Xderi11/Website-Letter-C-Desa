<?php 
include('../part/akses.php');
include('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');

// Query untuk mengambil satu data dari tabel surat_keterangan dengan status kepemilikan aktif
$query = "SELECT * FROM surat_keterangan WHERE status_kepemilikan = 'Aktif' ORDER BY tanggal DESC LIMIT 1";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);
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
        <li class="active treeview">
          <a href="#">
            <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li >
              <a href="../letter-c/"><i class="fa fa-circle-notch"></i> Letter C</a>
            </li>
            <li class="active">
              <a href="../surat-keterangan/"><i class="fa fa-circle-notch"></i> Surat Keterangan</a>
            </li>
          </ul>
        </li>
      </ul>
    </section>
</aside>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Informasi Surat Keterangan</h1>
        <ol class="breadcrumb">
            <li><a href="../../../../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="active">Surat Keterangan</li>
        </ol>
    </section>
    <section class="content">      
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h2 class="box-title"><i class="fas fa-envelope"></i> Surat Keterangan Aktif</h2>
                    </div>
                    <div class="box-body">
                        <?php if ($row) { ?>
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">ID Pejabat Desa</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?php echo ($row['id_pejabat_desa'] == 1 ? 'Tribowo, Kepala Desa' : ($row['id_pejabat_desa'] == 2 ? 'Yoyok Andrianto, Kasi Pemerintahan' : '')); ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">No Surat</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?php echo $row['no_surat']; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Keperluan</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?php echo $row['keperluan']; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Nama Pemilik</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?php echo $row['nama_pemilik']; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Alamat Pemilik</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?php echo $row['alamat_pemilik']; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">No Persil</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?php echo $row['no_persil']; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Kelas Desa</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?php echo $row['kelas_desa']; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Luas Milik</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?php echo $row['luas_milik']; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Jenis Tanah</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?php echo $row['jenis_tanah']; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Keterangan Tanah</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?php echo $row['keterangan_tanah']; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Status Kepemilikan</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="<?php echo $row['status_kepemilikan']; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <p>Tidak ada data surat keterangan dengan status kepemilikan aktif.</p>
                        <?php } ?>
                        <a href="cetak.php?id_sk=<?php echo $row['id_sk']; ?>" class="btn btn-primary">Cetak</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function printData() {
        var printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Print Data</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(document.querySelector('.content-wrapper').innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
    }
</script>

<?php 
include('../part/footer.php');
?>
