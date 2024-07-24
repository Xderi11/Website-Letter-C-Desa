<?php 
include ('../part/akses.php');
include ('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');

// Periksa apakah ada parameter detail yang dikirimkan melalui URL
if(isset($_GET['detail'])) {
    $no_persil = $_GET['detail'];

    // Query untuk mengambil data pemilik berdasarkan nomor persil dari tabel pemilik
    $query_detail = "SELECT p.nama_pemilik, p.alamat_pemilik, p.no_persil, t.keterangan_tanah, p.sebab_perubahan, p.status_kepemilikan 
                     FROM pemilik p 
                     LEFT JOIN tanah t ON p.no_persil = t.no_persil
                     WHERE p.no_persil = '$no_persil' AND p.status_kepemilikan = 'Aktif'";
    $result_detail = mysqli_query($connect, $query_detail);

    // Query untuk mengambil data perubahan berdasarkan nomor persil
    $query_perubahan = "SELECT pu.nik, pu.nama_pemilik, pu.alamat_pemilik, pu.kelas_desa, pu.luas_milik, pu.pajak_bumi, pu.no_persil, t.keterangan_tanah, pu.sebab_perubahan, pu.tanggal_perubahan, pu.status_kepemilikan 
                        FROM perubahan pu
                        LEFT JOIN tanah t ON pu.no_persil = t.no_persil
                        WHERE pu.no_persil = '$no_persil' AND pu.status_kepemilikan IS NOT NULL AND pu.status_kepemilikan != ''";
    $result_perubahan = mysqli_query($connect, $query_perubahan);

    // Query untuk mengambil data tanah berdasarkan nomor persil
    $query_tanah = "SELECT no_persil, kelas_desa, luas_milik, jenis_tanah, pajak_bumi, keterangan_tanah 
                    FROM tanah 
                    WHERE no_persil = '$no_persil'";
    $result_tanah = mysqli_query($connect, $query_tanah);

    if(mysqli_num_rows($result_detail) > 0 || mysqli_num_rows($result_perubahan) > 0) {
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
                    <li>
                        <a href="../laporan-kepemilikan/"><i class="fa fa-circle-notch"></i> Kepemilikan</a>
                    </li>
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
            <!-- Data Tanah -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Data Tanah: <?php echo $no_persil; ?></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered" style="margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th>No Persil</th>
                                    <th>Kelas Desa</th>
                                    <th>Luas Milik</th>
                                    <th>Jenis Tanah</th>
                                    <th>Pajak Bumi</th>
                                    <th>Keterangan Tanah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(mysqli_num_rows($result_tanah) > 0) {
                                    while ($row_tanah = mysqli_fetch_assoc($result_tanah)) { 
                                ?>
                                    <tr>
                                        <td><?php echo $row_tanah['no_persil']; ?></td>
                                        <td><?php echo $row_tanah['kelas_desa']; ?></td>
                                        <td><?php echo $row_tanah['luas_milik']; ?></td>
                                        <td><?php echo $row_tanah['jenis_tanah']; ?></td>
                                        <td>Rp. <?php echo number_format($row_tanah['pajak_bumi'], 2, ',', '.'); ?></td>
                                        <td><?php echo $row_tanah['keterangan_tanah']; ?></td>
                                    </tr>
                                <?php 
                                    } 
                                } else {
                                    echo "<tr><td colspan='6'>Data tidak ditemukan untuk nomor persil tersebut.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Data Perubahan -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Data Perubahan dengan Nomor Persil: <?php echo $no_persil; ?></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered" style="margin-top: 20px;">
                            <thead>
                            <tr>
                                    <th>NIK</th>
                                    <th>Nama Pemilik</th>
                                    <th>No Persil</th>
                                    <th>Kelas Desa</th>
                                    <th>Luas Milik</th>
                                    <th>Pajak Bumi</th>
                                    <th>Sebab dan Tanggal Perubahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while ($row_perubahan = mysqli_fetch_assoc($result_perubahan)) { 
                                    $sebab_dan_tanggal = $row_perubahan['sebab_perubahan'];
                                    if (!empty($row_perubahan['tanggal_perubahan'])) {
                                        $sebab_dan_tanggal .= ' (Tanggal: ' . date('d-m-Y', strtotime($row_perubahan['tanggal_perubahan'])) . ')';
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $row_perubahan['nik']; ?></td>
                                        <td><?php echo $row_perubahan['nama_pemilik']; ?></td>
                                        <td><?php echo $row_perubahan['no_persil']; ?></td>
                                        <td><?php echo $row_perubahan['kelas_desa']; ?></td>
                                        <td><?php echo $row_perubahan['luas_milik']; ?></td>
                                        <td>Rp. <?php echo number_format($row_perubahan['pajak_bumi'], 2, ',', '.'); ?></td>
                                        <td><?php echo $sebab_dan_tanggal; ?></td>
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

        <!-- Tombol Cetak -->
        <form id="printForm" action="cetak.php" method="post" target="_blank" style="text-align: right; margin-top: 20px;">
            <input type="hidden" name="no_persil" value="<?php echo $no_persil; ?>">
            <button type="submit" class="btn btn-primary" id="btnCetak">Cetak</button>
        </form>
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

