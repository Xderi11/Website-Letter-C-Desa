<?php 
include ('../part/akses.php');
include ('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');
$selected_id_pejabat_desa = 2;

// Periksa apakah ada parameter detail yang dikirimkan melalui URL
if (isset($_GET['detail'])) {
    $no_persil = $_GET['detail'];

    // Query untuk mengambil data pemilik dan perubahan berdasarkan nomor persil
    $query_detail = "
    SELECT 
        p.nama_pemilik, 
        p.alamat_pemilik, 
        p.no_persil, 
        p.keterangan_tanah, 
        p.sebab_perubahan, 
        p.status_kepemilikan,  
        pu.luas_milik AS luas_milik, 
        pu.kelas_desa AS kelas_desa,
        pu.jenis_tanah AS jenis_tanah,
        pu.pajak_bumi AS pajak_bumi,
        pu.tanggal AS tanggal
    FROM pemilik p
    LEFT JOIN perubahan pu ON p.no_persil = pu.no_persil
    WHERE p.no_persil = '$no_persil' AND (p.status_kepemilikan = 'Aktif' OR pu.status_kepemilikan = 'Aktif')
    ";

    $result_detail = mysqli_query($connect, $query_detail);

    if (mysqli_num_rows($result_detail) > 0) {
        $row = mysqli_fetch_assoc($result_detail); // Mengambil data dari hasil query

        // Format tanggal
        $tanggal = $row['tanggal'];
        $tgl = date('d', strtotime($tanggal));
        $bln = date('F', strtotime($tanggal));
        $thn = date(' Y', strtotime($tanggal));
        $blnIndo = array(
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        );
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
              <a href="../letter-c/"><i class="fa fa-circle-notch"></i> Kepemilikan</a>
            </li>
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
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
      <li><a href="../../../../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
      <li class="active">Permintaan Surat</li>
    </ol>
  </section>
  <section class="content">      
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-header with-border">
            <h2 class="box-title"><i class="fas fa-envelope"></i> Konfirmasi Surat Keterangan</h2>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>
          <div class="box-body">
            <form class="form-horizontal" method="post" action="update-konfirmasi.php">
              <div class="row">
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tanda Tangan</label>
                      <div class="col-sm-9">
                      <select name="ft_tangan" class="form-control" style="text-transform: uppercase;" required>
                        <option value="">-- Pilih Tanda Tangan --</option>
                        <?php
                        $qTampilPejabat = "SELECT * FROM pejabat_desa";
                        $tampilPejabat = mysqli_query($connect, $qTampilPejabat);

                        while ($pejabatRow = mysqli_fetch_assoc($tampilPejabat)) {
                        ?>
                        <option value="<?php echo $pejabatRow['id_pejabat_desa'];?>" <?php if ($pejabatRow['id_pejabat_desa'] == $selected_id_pejabat_desa) echo 'selected="selected"';?>>
                            <?php echo $pejabatRow['jabatan']. " (". $pejabatRow['nama_pejabat_desa']. ")";?>
                        </option>
                        <?php 
                        } 
                        ?>
                      </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">No. Surat</label>
                      <div class="col-sm-9">
                        <input type="text" name="fno_surat" value="<?php echo !empty($_POST['fno_surat']) ? $_POST['fno_surat'] : ''; ?>" class="form-control" placeholder="Masukkan No. Surat" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Keperluan</label>
                      <div class="col-sm-9">
                        <input type="text" name="fkeperluan" class="form-control" placeholder="Masukkan Keperluan" required>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <h5 class="box-title pull-right" style="color: #696969;"><i class="fas fa-info-circle"></i> <b>Informasi Data Letter C</b></h5>
              <br><hr style="border-bottom: 1px solid #DCDCDC;">
              <div class="row">
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Nama Lengkap</label>
                      <div class="col-sm-9">
                        <input type="text" name="fnama_pemilik" style="text-transform: uppercase;" value="<?php echo $row['nama_pemilik']; ?>" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Alamat Pemilik</label>
                      <div class="col-sm-9">
                        <input type="text" name="falamat_pemilik" style="text-transform: capitalize;" value="<?php echo $row['alamat_pemilik']; ?>" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">No Persil</label>
                      <div class="col-sm-9">
                        <input type="text" name="fno_persil" style="text-transform: capitalize;" value="<?php echo $row['no_persil']; ?>" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Kelas Desa</label>
                      <div class="col-sm-9">
                        <input type="text" name="fkelas_desa" style="text-transform: capitalize;" value="<?php echo $row['kelas_desa']; ?>" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Luas Lahan</label>
                      <div class="col-sm-9">
                        <input type="text" name="fluas_milik" style="text-transform: capitalize;" value="<?php echo $row['luas_milik']; ?>" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Jenis Tanah</label>
                      <div class="col-sm-9">
                        <input type="text" name="fjenis_tanah" style="text-transform: capitalize;" value="<?php echo $row['jenis_tanah']; ?>" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Tanggal Penerbitan</label>
                      <div class="col-sm-9">
                        <input type="text" name="ftanggal" style="text-transform: capitalize;" value="<?php echo $tgl . $blnIndo[$bln] . $thn; ?>" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Status Tanah</label>
                      <div class="col-sm-9">
                        <input type="text" name="fketerangan_tanah" style="text-transform: capitalize;" value="<?php echo $row['keterangan_tanah']; ?>" class="form-control" readonly>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Sebab Perubahan</label>
                      <div class="col-sm-9">
                        <input type="text" name="fsebab_perubahan" style="text-transform: capitalize;" value="<?php echo $row['sebab_perubahan']; ?>" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Pajak Bumi</label>
                      <div class="col-sm-9">
                        <input type="text" name="fpajak_bumi" style="text-transform: capitalize;" value="<?php echo $row['pajak_bumi']; ?>" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Status Kepemilikan</label>
                      <div class="col-sm-9">
                        <input type="text" name="fstatus_kepemilikan" style="text-transform: capitalize;" value="<?php echo $row['status_kepemilikan']; ?>" class="form-control" readonly>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" name="update" class="btn btn-info pull-right"><i class="fas fa-check"></i> Konfirmasi</button>
                <a href="index.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php 
    } else {
        echo "<script>alert('Data tidak ditemukan.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php?page=index'>";
    }
} else {
    echo "<script>alert('Nomor persil tidak disediakan.');</script>";
    echo "<meta http-equiv='refresh' content='0; url=index.php?page=index'>";
}
include ('../part/footer.php');
?>
