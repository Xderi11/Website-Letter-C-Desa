<?php
session_start();
include ('../../config/koneksi.php');

if(isset($_POST['submit'])) {
    $nama_pemilik = $_POST['fnama_pemilik'] ?? '';
    $alamat_pemilik = $_POST['falamat_pemilik'] ?? '';
    $no_persil = $_POST['fno_persil'] ?? '';
    $kelas_desa = $_POST['fkelas_desa'] ?? '';
    $luas_milik = $_POST['fluas_milik'] ?? '';
    $jenis_tanah = $_POST['fjenis_tanah'] ?? '';
    $tanggal = $_POST['ftanggal'] ?? '';
    $pajak_bumi = str_replace('.', '', $_POST['fpajak_bumi']) ?? ''; // Menghapus titik sebagai pemisah ribuan
    $keterangan_tanah = $_POST['fketerangan_tanah'] ?? '';
    $id_kepemilikan = $_POST['fid_kepemilikan'] ?? ''; // Ambil id_kepemilikan dari form atau sesuai dengan logika aplikasi

    // Siapkan query untuk memasukkan data baru ke pemilik
    $query_insert_pemilik = "
        INSERT INTO pemilik (nama_pemilik, alamat_pemilik, no_persil, tanggal, keterangan_tanah, sebab_perubahan, status_kepemilikan, id_kepemilikan)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";

    $stmt_insert_pemilik = $connect->prepare($query_insert_pemilik);
    $stmt_insert_pemilik->bind_param("ssssssss", $nama_pemilik, $alamat_pemilik, $no_persil, $tanggal, $keterangan_tanah, $sebab_perubahan, $status_kepemilikan, $id_kepemilikan);

    if ($stmt_insert_pemilik->execute()) {
        $_SESSION['success_message'] = "Data Letter C berhasil ditambahkan.";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Gagal menambahkan data Letter C: " . $stmt_insert_pemilik->error;
        header("Location: tambah-penduduk.php");
        exit;
    }
}

mysqli_close($connect);
?>




<?php 
include ('../part/header.php');
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
            <li>
              <a href="../data-tanah/"><i class="fa fa-circle-notch"></i> Data Tanah</a>
            </li>
            <li class="active">
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
          
        <?php
          if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
        ?>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Surat</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="../surat/buat_surat/"><i class="fa fa-circle-notch"></i> Buat Surat</a>
            </li>
            <li>
              <a href="../surat/permintaan_surat/"><i class="fa fa-circle-notch"></i> Permintaan Surat</a>
            </li>
            <li>
              <a href="../surat/surat_selesai/"><i class="fa fa-circle-notch"></i> Surat Selesai</a>
            </li>
          </ul>
        </li>
        <?php 
          }
        ?>
        <li>
          <a href="../laporan/"><i class="fas fa-chart-line"></i> <span>&nbsp;&nbsp;Laporan</span></a>
        </li>
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
            <?php
                if(isset($_SESSION['error_message'])) {
                    echo "<div class='alert alert-danger'>".$_SESSION['error_message']."</div>";
                    unset($_SESSION['error_message']);
                }

                if(isset($_SESSION['success_message'])) {
                    echo "<div class='alert alert-success'>".$_SESSION['success_message']."</div>";
                    unset($_SESSION['success_message']);
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
                                            <label class="col-sm-4 control-label">Nama Pemilik</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="fnama_pemilik" class="form-control" style="text-transform: capitalize;" placeholder="Nama Pemilik" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Alamat Pemilik</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="falamat_pemilik" class="form-control" style="text-transform: capitalize;" placeholder="Alamat Pemilik" required>
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
                                            <input type="reset" class="btn btn-default" value="Batal">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    console.log(response); // <-- Tambahkan ini untuk debug
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