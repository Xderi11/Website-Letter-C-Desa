<?php 
  include ('../part/akses.php');
  include ('../../config/koneksi.php');
  include ('../part/header.php');

  $id = $_GET['id'];
  $qCek = mysqli_query($connect,"SELECT * FROM penduduk WHERE id_penduduk='$id'");
  while($row = mysqli_fetch_array($qCek)){
?>

<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <?php  
          if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
            echo '<img src="../../assets/img/ava-admin-female.png" class="img-circle" alt="User Image">';
          }else if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Kepala Desa')){
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
      <li class="active">
        <a href="../penduduk/">
          <i class="fa fa-users"></i><span>&nbsp;Data Letter C</span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Surat</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="../surat/permintaan_surat/">
              <i class="fa fa-circle-notch"></i> Permintaan Surat
            </a>
          </li>
          <li>
            <a href="../surat/surat_selesai/"><i class="fa fa-circle-notch"></i> Surat Selesai
            </a>
          </li>
        </ul>
      </li>
      <li>
        <a href="../laporan/">
          <i class="fas fa-chart-line"></i> <span>&nbsp;&nbsp;Laporan</span>
        </a>
      </li>
    </ul>
  </section>
</aside>
<div class="content-wrapper">
  <section class="content-header">
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
      <li><a href="../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
      <li class="active">Data Letter C</li>
    </ol>
  </section>
  <section class="content">      
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fas fa-edit"></i> Edit Data Letter C</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <form class="form-horizontal" method="post" action="update-penduduk.php">
                <div class="col-md-6">
                  <div class="box-body">
                    <input type="hidden" name="id" class="form-control" value="<?php echo $row['id_penduduk']; ?>">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Nama Pemilik</label>
                      <div class="col-sm-8">
                        <input type="text" name="fnama_pemilik"  class="form-control" style="text-transform: capitalize;"placeholder="Nama Pemilik" value="<?php echo $row['nama_pemilik']; ?>" required>
                       
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Alamat Pemilik</label>
                      <div class="col-sm-8">
                        <input type="text" name="falamat_pemilik" class="form-control" style="text-transform: capitalize;" placeholder="alamat Pemilik" value="<?php echo $row['alamat_pemilik']; ?>" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">No Persil</label>
                      <div class="col-sm-8">
                        <input type="text" name="fno_persil" class="form-control" style="text-transform: capitalize;" placeholder="No Persil" value="<?php echo $row['no_persil']; ?>" required>                   
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Kelas Desa</label>
                      <div class="col-sm-8">
                        <input type="text" name="fkelas_desa" class="form-control" style="text-transform: capitalize;" placeholder="Kelas Desa" value="<?php echo $row['kelas_desa']; ?>" required>                   
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Luas Milik</label>
                      <div class="col-sm-8">
                        <input type="text" name="fluas_milik" class="form-control" style="text-transform: capitalize;" placeholder="Luas Milik" value="<?php echo $row['luas_milik']; ?>" required>                   
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Jenis Tanah</label>
                      <div class="col-sm-8">
                        <input type="text" name="fjenis_tanah" class="form-control" style="text-transform: capitalize;" placeholder="Jenis Tanah" value="<?php echo $row['jenis_tanah']; ?>" required>                   
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Tanggal</label>
                      <div class="col-sm-8">
                        <input type="date" name="ftanggal" class="form-control" value="<?php echo $row['tanggal']; ?>" required>
                      </div>
                    </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Sebab Perubahan</label>
                      <div class="col-sm-8">
                        <input type="text" name="fsebab_perubahan" class="form-control" style="text-transform: capitalize;" placeholder="sebab perubahan" value="<?php echo $row['sebab_perubahan']; ?>" required>                   
                      </div>
                    
                  </div>
                  <div class="box-footer pull-right">
                    <input type="reset" class="btn btn-default" value="Batal">
                    <input type="submit" name="submit" class="btn btn-info" value="Submit">
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="box-footer">
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
  }

  include ('../part/footer.php');
?>