<?php
 include ('../part/akses.php');

// Include database connection
include ('../../config/koneksi.php');

// Fetch NIK from database for dropdown
$query = "SELECT nik FROM identitas";
$result = $connect->query($query);
?>

<?php include('../part/header.php'); ?>

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
        <li class="active">
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
        <h1>Tambah Data Letter C</h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="active">Tambah Data Letter C</li>
        </ol>
    </section>

    <section class="content">      
        <div class="row">
            <div class="col-md-12">
            <!-- Tampilkan pesan error jika ada -->
            <?php 
                        if (isset($error_message) && $error_message !== ""){
                            echo "<div class='alert alert-danger'><center>$error_message</center></div>";
                        }
                        if (isset($success_message) && $success_message !== ""){
                            echo "<div class='alert alert-success'><center>$success_message</center></div>";
                        }
                    ?>
                <br>
            </div>
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fas fa-user-plus"></i> Tambah Data Letter C</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <form class="form-horizontal" method="post" action="simpan-penduduk.php">
                                <div class="col-md-6">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">NIK</label>
                                            <div class="col-sm-8">
                                                <select name="fnik" class="form-control" id="nikSelect" required>
                                                    <option value="">Pilih NIK</option>
                                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                                        <option value="<?php echo $row['nik']; ?>"><?php echo $row['nik']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Nama Pemilik</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="fnama_pemilik" class="form-control" style="text-transform: capitalize;" placeholder="Nama Pemilik" required readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Alamat Pemilik</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="falamat_pemilik" class="form-control" style="text-transform: capitalize;" placeholder="Alamat Pemilik" required readonly>
                                            </div>
                                        </div>
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
                                            <label class="col-sm-4 control-label">Luas Milik</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="fluas_milik" class="form-control" style="text-transform: capitalize;" placeholder="Luas Lahan" required>                   
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
                                                <input type="text" name="fpajak_bumi" class="form-control" style="text-transform: capitalize;" placeholder="Pajak Bumi" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Keterangan Tanah</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="fketerangan_tanah" class="form-control" style="text-transform: capitalize;" placeholder="Keterangan Tanah" required>                   
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Tanggal Penerbitan</label>
                                            <div class="col-sm-8">
                                                <input type="date" name="ftanggal" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="box-footer pull-right">
                                            <input type="button" class="btn btn-danger" value="Batal" onclick="location.href='index.php'">
                                            <input type="submit" class="btn btn-primary" value="Simpan">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?php include('../part/footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#nikSelect').on('change', function(){
        var nik = $(this).val();
        if(nik) {
            $.ajax({
                type: 'POST',
                url: 'get-data-identitas.php',
                data: {nik: nik},
                dataType: 'json',
                success: function(response){
                    if(response.error) {
                        alert(response.error);
                    } else {
                        $('input[name="fnama_pemilik"]').val(response.nama_pemilik);
                        $('input[name="falamat_pemilik"]').val(response.alamat_pemilik);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);
                }
            });
        } else {
            // Clear the form fields if no NIK is selected
            $('input[name="fnama_pemilik"]').val('');
            $('input[name="falamat_pemilik"]').val('');
        }
    });
});

</script>
<script>
$(document).ready(function(){
    $('input[name="fno_persil"]').on('blur', function(){
        var no_persil = $(this).val();
        if(no_persil) {
            $.ajax({
                type: 'POST',
                url: 'get-data-tanah.php',
                data: {no_persil: no_persil},
                dataType: 'json',
                success: function(response){
                    if(response.error) {
                        alert(response.error);
                    } else {
                        $('input[name="fnama_pemilik"]').val(response.nama_pemilik);
                        $('input[name="falamat_pemilik"]').val(response.alamat_pemilik);
                        $('input[name="fkelas_desa"]').val(response.kelas_desa);
                        $('input[name="fluas_milik"]').val(response.luas_milik);
                        $('input[name="fjenis_tanah"]').val(response.jenis_tanah);
                        $('input[name="fpajak_bumi"]').val(response.pajak_bumi);
                        $('input[name="fketerangan_tanah"]').val(response.keterangan_tanah);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);
                }
            });
        }
    });
});
</script>
