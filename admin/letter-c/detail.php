<?php 
include ('../part/akses.php');
include ('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');

// Periksa apakah ada parameter detail yang dikirimkan melalui URL
if(isset($_GET['detail'])) {
    $no_persil = $_GET['detail'];

    // Query untuk mengambil data pemilik berdasarkan nomor persil dari tabel pemilik dan perubahan
    $query_detail = "SELECT p.nama_pemilik, p.alamat_pemilik, p.no_persil, t.keterangan_tanah, p.sebab_perubahan, p.status_kepemilikan 
                     FROM pemilik p 
                     LEFT JOIN tanah t ON p.no_persil = t.no_persil
                     WHERE p.no_persil = '$no_persil' AND p.status_kepemilikan = 'Aktif'
                     UNION
                     SELECT pu.nama_pemilik, pu.alamat_pemilik, pu.no_persil, t.keterangan_tanah, pu.sebab_perubahan, pu.status_kepemilikan 
                     FROM perubahan pu
                     LEFT JOIN tanah t ON pu.no_persil = t.no_persil
                     WHERE pu.no_persil = '$no_persil' AND pu.status_kepemilikan = 'Tidak Aktif'";
    
    $result_detail = mysqli_query($connect, $query_detail);

    if(mysqli_num_rows($result_detail) > 0) {

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
            
            <?php
            if(isset($_SESSION['lvl']) && ($_SESSION['lvl'] == 'Administrator')){
            ?>
            <li class=" active treeview">
                <a href="#">
                    <i class="fas fa-envelope-open-text"></i> <span>&nbsp;&nbsp;Laporan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active">
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
        <h1>Detail Data Pemilik Letter C</h1>
        <ol class="breadcrumb">
            <li><a href="../dashboard/"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="../perubahan/"><i class="fas fa-exchange-alt"></i> Perubahan</a></li>
            <li class="active">Detail Data Pemilik</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Detail Pemilik dengan Nomor Persil: <?php echo $no_persil; ?></h3>
                    </div>

                    
                    <table class="table table-bordered" style="margin-top: 20px;">
                        <thead>
                            <tr>
                                <th>Nama Pemilik</th>
                                <th>Alamat Pemilik</th>
                                <th>Nomor Persil</th>
                                <th>Keterangan Tanah</th>
                                <th>Sebab Perubahan</th>
                                <th>Status Kepemilikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row_detail = mysqli_fetch_assoc($result_detail)) { ?>
                                <tr>
                                    <td><?php echo $row_detail['nama_pemilik']; ?></td>
                                    <td><?php echo $row_detail['alamat_pemilik']; ?></td>
                                    <td><?php echo $row_detail['no_persil']; ?></td>
                                    <td><?php echo $row_detail['keterangan_tanah']; ?></td>
                                    <td><?php echo $row_detail['sebab_perubahan']; ?></td>
                                    <td><?php echo $row_detail['status_kepemilikan']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <form id="printForm" action="cetak.php" method="post" target="_blank" style="text-align: right; margin-top: 20px;">
    <input type="hidden" name="no_persil" value="<?php echo $no_persil; ?>">
    <button type="submit" class="btn btn-primary" id="btnCetak">Cetak</button>
</form>


                </div>
            </div>
        </div>
    </section>
</div>

<?php 
    } else {
        echo "<div class='alert alert-danger'><center>Data tidak ditemukan untuk nomor persil tersebut.</center></div>";
    }

    // Tutup koneksi database
    mysqli_close($connect);
} else {
    echo "<div class='alert alert-danger'><center>Parameter detail tidak valid.</center></div>";
}

include ('../part/footer.php');
?>


<script>
document.getElementById("btnCetak").addEventListener("click", function() {
    // Ketika tombol "Cetak" ditekan, submit form untuk mencetak
    document.getElementById("printForm").submit();
});
</script>