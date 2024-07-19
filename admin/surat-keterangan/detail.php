<?php 
include ('../part/akses.php');
include ('../part/header.php');

// Koneksi ke database
include('../../config/koneksi.php');

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
        IFNULL(p.luas_milik, pu.luas_milik) AS luas_milik,
        IFNULL(p.jenis_tanah, pu.jenis_tanah) AS jenis_tanah,
        IFNULL(p.tanggal, pu.tanggal) AS tanggal
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
                            while ($rows = mysqli_fetch_assoc($tampilPejabat)) {
                          ?>
                          <option value="<?php echo $rows['id_pejabat_desa']; ?>" <?php if ($rows['id_pejabat_desa'] == $row['id_pejabat_desa']) echo 'selected="selected"'; ?>>
                            <?php echo $rows['jabatan'] . " (" . $rows['nama_pejabat_desa'] . ")"; ?>
                          </option>
                          <?php 
                            } 
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-3 control-label">No. Surat</label>
                      <div class="col-sm-9">
                        <input type="text" name="fno_surat" value="<?php echo $row['no_surat']; ?>" class="form-control" placeholder="Masukkan No. Surat" required>
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
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="box-body pull-right">
                    <input type="submit" name="submit" class="btn btn-success" value="Konfirmasi">
                  </div>
                </div>
              </div>
              <input type="hidden" name="id" value="<?php echo $row['no_persil']; ?>">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php
    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    echo "Nomor Persil tidak ditentukan.";
}
?>

