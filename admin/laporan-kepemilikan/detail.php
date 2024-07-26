<?php 
include ('../part/akses.php');
include ('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');

// Periksa apakah ada parameter nik yang dikirimkan melalui URL
if(isset($_GET['nik'])) {
    $nik = $_GET['nik'];

    // Query untuk mengambil data pemilik berdasarkan nik dari tabel pemilik
    $query_pemilik = "SELECT nik, nama_pemilik, no_persil, tanggal, tanggal_perubahan, sebab_perubahan, status_kepemilikan 
                      FROM pemilik 
                      WHERE nik = '$nik'";
    
    $result_pemilik = mysqli_query($connect, $query_pemilik);

    // Query untuk mengambil data pemilik berdasarkan nik dari tabel perubahan
    $query_perubahan = "SELECT nik, nama_pemilik, no_persil, tanggal, tanggal_perubahan, sebab_perubahan, status_kepemilikan 
                        FROM perubahan 
                        WHERE nik = '$nik' AND status_kepemilikan IS NOT NULL AND status_kepemilikan != '' order by tanggal_perubahan desc";
    
    $result_perubahan = mysqli_query($connect, $query_perubahan);

    if(mysqli_num_rows($result_pemilik) > 0 || mysqli_num_rows($result_perubahan) > 0) {
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
                        <a href="../perubahan/"><i class="fa fa-circle-notch"></i> Perubahan</a>
                    </li>
                    <li>
                        <a href="../kepemilikan/"><i class="fa fa-circle-notch"></i> Kepemilikan</a></li>
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
                        <a href="../laporan-kepemilikan/"><i class="fa fa-circle-notch"></i> Kepemilikan</a>
                    </li>
                    <li >
                        <a href="../letter-c/"><i class="fa fa-circle-notch"></i> Letter C</a></li>
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
            <!-- Print Button -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Kepemilikan Tanah dengan NIK: <?php echo $nik; ?></h3>
                        <!-- Print Button -->
                        <a href="cetak.php?nik=<?php echo $nik; ?>" class="btn btn-primary pull-right" target="_blank">Cetak</a>
                    </div>

                    <!-- Data from pemilik table -->
                    <div class="box-body">
                        <table class="table table-bordered" style="margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama Pemilik</th>
                                    <th>Nomor Persil</th>
                                    <th>Tanggal Penerbitan</th>
                                    <th>Tanggal Perubahan</th>
                                    <th>Sebab Perubahan</th>
                                    <th>Status Kepemilikan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while ($row_pemilik = mysqli_fetch_assoc($result_pemilik)) { 
                                ?>
                                    <tr>
                                        <td><?php echo $row_pemilik['nik']; ?></td>
                                        <td><?php echo $row_pemilik['nama_pemilik']; ?></td>
                                        <td><?php echo $row_pemilik['no_persil']; ?></td>
                                        <td><?php echo $row_pemilik['tanggal']; ?></td>
                                        <td><?php echo $row_pemilik['tanggal_perubahan']; ?></td>
                                        <td><?php echo $row_pemilik['sebab_perubahan']; ?></td>
                                        <td><?php echo $row_pemilik['status_kepemilikan']; ?></td>
                                    </tr>
                                <?php 
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Data from perubahan table -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Riwayat Kepemilikan Berdasarkan NIK:<?php echo $nik; ?></h3>
                    </div>

                    <div class="box-body">
                        <table class="table table-bordered" style="margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama Pemilik</th>
                                    <th>Nomor Persil</th>
                                    <th>Tanggal Penerbitan</th>
                                    <th>Tanggal Perubahan</th>
                                    <th>Sebab Perubahan</th>
                                    <th>Status Kepemilikan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while ($row_perubahan = mysqli_fetch_assoc($result_perubahan)) { 
                                ?>
                                    <tr>
                                        <td><?php echo $row_perubahan['nik']; ?></td>
                                        <td><?php echo $row_perubahan['nama_pemilik']; ?></td>
                                        <td><?php echo $row_perubahan['no_persil']; ?></td>
                                        <td><?php echo $row_perubahan['tanggal']; ?></td>
                                        <td><?php echo $row_perubahan['tanggal_perubahan']; ?></td>
                                        <td><?php echo $row_perubahan['sebab_perubahan']; ?></td>
                                        <td><?php echo $row_perubahan['status_kepemilikan']; ?></td>
                                    </tr>
                                <?php 
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php 
    } else {
        echo "<div class='alert alert-danger'><center>Data tidak ditemukan untuk NIK tersebut.</center></div>";
    }

    // Tutup koneksi database
    mysqli_close($connect);
} else {
    echo "<div class='alert alert-danger'><center>Parameter NIK tidak valid.</center></div>";
}

include ('../part/footer.php');
?>

<script>
document.getElementById("btnCetak").addEventListener("click", function() {
    // Ketika tombol "Cetak" ditekan, buka halaman cetak.php dengan parameter NIK
    window.open('cetak.php?nik=<?php echo $nik; ?>', '_blank');
});
</script>

