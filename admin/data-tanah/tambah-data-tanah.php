<?php 
  include ('../part/akses.php');
  include ('../part/header.php');
  include ('../../config/koneksi.php');
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
    <h1>&nbsp;</h1>
    <ol class="breadcrumb">
      <li><a href="../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
      <li class="active">Data Tanah</li>
    </ol>
  </section>

  <section class="content">      
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fas fa-user-plus"></i> Tambah Data Tanah</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <form class="form-horizontal" method="post" action="simpan-data-tanah.php">
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">No Persil</label>
                      <div class="col-sm-8">
                        <input type="text" name="fno_persil" class="form-control" pattern="\d*" title="Hanya angka yang diperbolehkan" placeholder="No Persil" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Kelas Desa</label>
                      <div class="col-sm-8">
                        <input type="text" name="fkelas_desa" class="form-control" style="text-transform: capitalize;" placeholder="Kelas Desa" required>                   
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Luas Lahan</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <input type="text" name="fluas_milik" class="form-control" placeholder="Luas Lahan" required>
                          <span class="input-group-addon">M<sup>2</sup></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Jenis Tanah</label>
                      <div class="col-sm-8">
                        <input type="text" name="fjenis_tanah" class="form-control" style="text-transform: capitalize;" placeholder="Jenis Tanah" required>                   
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Pajak Bumi</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <span class="input-group-addon">Rp</span>
                          <input type="text" name="fpajak_bumi" class="form-control" pattern="\d*" title="Hanya angka yang diperbolehkan" placeholder="Pajak Bumi (hanya angka)" required>                   
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Keterangan Tanah</label>
                      <div class="col-sm-8">
                        <input type="text" name="fketerangan_tanah" class="form-control" style="text-transform: capitalize;" placeholder="Keterangan Tanah" required>                   
                      </div>
                    </div>
                    <div class="box-footer pull-right">
                      <input type="button" class="btn btn-default" value="Batal" onclick="window.location.href='index.php';">
                      <input type="submit" name="submit" class="btn btn-info" value="Submit">
                    </div>
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
  include ('../part/footer.php');
?>
