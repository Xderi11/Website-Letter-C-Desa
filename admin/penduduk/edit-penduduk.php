<?php 
include ('../part/akses.php');
include ('../../config/koneksi.php');
include ('../part/header.php');

$id = $_GET['id'];
$qCek = mysqli_query($connect,"SELECT * FROM kepemilikan_letter_c WHERE id_kepemilikan='$id'");
$row = mysqli_fetch_assoc($qCek);
?>

<aside class="main-sidebar">
  <!-- Sidebar content -->
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
                    <input type="hidden" name="id" class="form-control" value="<?php echo $row['id_kepemilikan']; ?>">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Nama Pemilik</label>
                      <div class="col-sm-8">
                        <input type="text" name="fnama_pemilik"  class="form-control" style="text-transform: capitalize;" placeholder="Nama Pemilik" value="<?php echo $row['nama_pemilik']; ?>" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Alamat Pemilik</label>
                      <div class="col-sm-8">
                        <input type="text" name="falamat_pemilik" class="form-control" style="text-transform: capitalize;" placeholder="Alamat Pemilik" value="<?php echo $row['alamat_pemilik']; ?>" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">No Persil</label>
                      <div class="col-sm-8">
                        <input type="number" name="fno_persil" class="form-control" placeholder="No Persil" value="<?php echo $row['no_persil']; ?>" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Kelas Desa</label>
                      <div class="col-sm-8">
                        <input type="text" name="fkelas_desa" class="form-control" style="text-transform: capitalize;" placeholder="Kelas Desa" value="<?php echo $row['kelas_desa']; ?>" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Luas Lahan</label>
                      <div class="col-sm-8">
                        <input type="text" name="fluas_milik" class="form-control" style="text-transform: capitalize;" placeholder="Luas Lahan" value="<?php echo $row['luas_milik']; ?>" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Jenis Tanah</label>
                      <div class="col-sm-8">
                        <input type="text" name="fjenis_tanah" class="form-control" style="text-transform: capitalize;" placeholder="Jenis Tanah" value="<?php echo $row['jenis_tanah']; ?>" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Tanggal Penerbitan</label>
                      <div class="col-sm-8">
                        <input type="date" name="ftanggal" class="form-control" value="<?php echo $row['tanggal']; ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Pajak Bumi</label>
                    <div class="col-sm-8">
                      <input type="text" name="fpajak_bumi" class="form-control" style="text-transform: capitalize;" placeholder="Pajak Bumi" value="<?php echo $row['pajak_bumi']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Keterangan Tanah</label>
                    <div class="col-sm-8">
                      <input type="text" name="fketerangan_tanah" class="form-control" style="text-transform: capitalize;" placeholder="Keterangan Tanah" value="<?php echo $row['keterangan_tanah']; ?>" required>
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
include ('../part/footer.php');
?>