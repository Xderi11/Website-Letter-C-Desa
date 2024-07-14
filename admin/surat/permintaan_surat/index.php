<?php
  include ('../../../config/koneksi.php');
  include ('../part/akses.php');
  include ('../part/header.php');
?>

<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <?php  
          if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
            echo '<img src="../../../assets/img/ava-admin-female.png" class="img-circle" alt="User Image">';
          }else if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Kepala Desa')){
            echo '<img src="../../../assets/img/ava-kades.png" class="img-circle" alt="User Image">';
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
        <a href="../../dashboard/">
          <i class="fas fa-tachometer-alt"></i> <span>&nbsp;&nbsp;Dashboard</span>
        </a>
      </li>
      <li>
        <a href="../../penduduk/">
          <i class="fa fa-users"></i> <span>Data Letter C</span>
        </a>
      </li>
      <li class="active treeview">
        <a href="#">
          <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Surat</span>
          <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="../../surat/buat_surat/">
              <i class="fa fa-circle-notch"></i> Buat Surat
            </a>
          </li>
          <li class="active">
            <a href="#">
              <i class="fa fa-circle-notch"></i> Permintaan Surat
            </a>
          </li>
          <li>
            <a href="../../surat/surat_selesai/">
              <i class="fa fa-circle-notch"></i> Surat Selesai
            </a>
          </li>
        </ul>
      </li>
      <li>
        <a href="../../laporan/">
          <i class="fas fa-chart-line"></i> <span>&nbsp;&nbsp;Laporan</span>
        </a>
      </li>
    </ul>
  </section>
</aside>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Permintaan Surat</h1>
    <ol class="breadcrumb">
      <li><a href="../../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
      <li class="active">Permintaan Surat</li>
    </ol>
  </section>

  <section class="content">      
    <div class="row">
      <div class="col-md-12">
        <br><br>
        <table class="table table-striped table-bordered table-responsive" id="data-table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th><strong>No.</strong></th>
              <th><strong>Tanggal Penerbitan</strong></th>
              <th><strong>No Persil</strong></th>
              <th><strong>Nama</strong></th>
              <th><strong>Jenis Surat</strong></th>
              <th><strong>Status</strong></th>
              <th><strong>Aksi</strong></th>
            </tr>
          </thead>
          <tbody>
            <?php
              $qTampil = mysqli_query($connect, "SELECT penduduk.nama_pemilik, surat_keterangan.id_sk, surat_keterangan.no_surat, surat_keterangan.no_persil, surat_keterangan.jenis_surat, surat_keterangan.status_surat, surat_keterangan.tanggal_surat FROM penduduk LEFT JOIN surat_keterangan ON surat_keterangan.no_persil = penduduk.no_persil WHERE surat_keterangan.status_surat='pending'");
              if ($qTampil->num_rows > 0){
                $nomor = 1; // Inisialisasi nomor urut
                foreach ($qTampil as $row){ 
            ?>
                <tr>
                  <td><?php echo $nomor++; ?></td>
                  <?php
                    $tgl_lhr = date($row['tanggal_surat']);
                    $tgl = date('d ', strtotime($tgl_lhr));
                    $bln = date('F', strtotime($tgl_lhr));
                    $thn = date(' Y', strtotime($tgl_lhr));
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
                  <td><?php echo $tgl . $blnIndo[$bln] . $thn; ?></td>
                  <td><?php echo $row['no_persil']; ?></td>
                  <td style="text-transform: capitalize;"><?php echo $row['nama_pemilik']; ?></td>
                  <td><?php echo $row['jenis_surat']; ?></td>
                  <td><a class="btn btn-danger btn-sm" href='#'><i class="fa fa-spinner"></i><b> <?php echo $row['status_surat']; ?></b></a></td>
                  <td>
                    <?php  
                      if($row['jenis_surat']=="Surat Keterangan"){
                    ?>
                    <a class="btn btn-success btn-sm" href='konfirmasi/surat_keterangan/index.php?id=<?php echo $row['id_sk']; ?>'><i class="fa fa-check"></i><b> KONFIRMASI</b></a>
                    <?php
                      }
                    ?>
                  </td>
                </tr>
            <?php 
                } 
              } else {
                // Handle jika tidak ada data yang ditemukan
                echo '<tr><td colspan="7">Tidak ada data yang ditemukan</td></tr>';
              }
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
