<?php 
include('../part/akses.php');
include('../../config/koneksi.php');

// Pastikan ID SK sudah ada
$id_sk = isset($_GET['id_sk']) ? $_GET['id_sk'] : '';

// Query untuk mengambil data dari tabel profil_desa
$profil_query = "SELECT * FROM profil_desa";
$profil_result = mysqli_query($connect, $profil_query);
$profil_data = mysqli_fetch_assoc($profil_result);

// Query untuk mengambil data dari tabel surat_keterangan, kepemilikan_letter_c, dan pejabat_desa
$query = "SELECT kepemilikan_letter_c.*, surat_keterangan.*, pejabat_desa.nama_pejabat_desa, pejabat_desa.jabatan 
          FROM kepemilikan_letter_c 
          LEFT JOIN surat_keterangan ON surat_keterangan.no_persil = kepemilikan_letter_c.no_persil 
          LEFT JOIN pejabat_desa ON pejabat_desa.id_pejabat_desa = surat_keterangan.id_pejabat_desa
          WHERE surat_keterangan.id_sk='$id_sk'";

$result = mysqli_query($connect, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($connect));
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="../../assets/img/logo-karimun-mini.png">
    <title>Cetak Surat</title>
    <link href="../../assets/formsuratCSS/formsurat.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        @media print {
            @page { margin: 0; }
            body { 
                margin: 1cm;
                margin-left: 2cm;
                margin-right: 2cm;
                font-family: "Times New Roman", Times, serif;
            }
        }
    </style>
</head>
<body>
    <div>
        <table width="100%">
            <tr><img src="../../assets/img/logo-surat.png" alt="" class="logo"></tr>
            <div class="header">
                <h4 class="kop" style="text-transform: uppercase">PEMERINTAH <?php echo isset($profil_data['kabupaten']) ? $profil_data['kabupaten'] : 'Data tidak tersedia'; ?></h4>
                <h4 class="kop" style="text-transform: uppercase">KECAMATAN <?php echo isset($profil_data['kecamatan']) ? $profil_data['kecamatan'] : 'Data tidak tersedia'; ?></h4>
                <h4 class="kop" style="text-transform: uppercase">DESA <?php echo isset($profil_data['nama_desa']) ? $profil_data['nama_desa'] : 'Data tidak tersedia'; ?></h4>
                <h5 class="kop2" style="text-transform: capitalize;"><?php echo isset($profil_data['alamat']) ? $profil_data['alamat'] : 'Data tidak tersedia'; ?> Telp. <?php echo isset($profil_data['no_telpon']) ? $profil_data['no_telpon'] : 'Data tidak tersedia'; ?> Kode Pos <?php echo isset($profil_data['kode_pos']) ? $profil_data['kode_pos'] : 'Data tidak tersedia'; ?></h5>
                <div style="text-align: center;">
                    <hr>
                </div>
            </div>
            <br>
            <div align="center"><u><h4 class="kop">SURAT KETERANGAN</h4></u></div>
            <div align="center"><h4 class="kop3">Nomor :&nbsp;&nbsp;&nbsp;<?php echo isset($data['no_surat']) ? $data['no_surat'] : 'Data tidak tersedia'; ?></h4></div>
        </table>
        <br>
        <div class="clear"></div>
        <div id="isi3">
            <table width="100%">
                <tr>
                    <td class="indentasi">Yang bertanda tangan di bawah ini, <a style="text-transform: capitalize;"><?php echo isset($data['jabatan']) ? $data['jabatan'] : 'Data tidak tersedia'; ?> <?php echo isset($profil_data['nama_desa']) ? $profil_data['nama_desa'] : 'Data tidak tersedia'; ?>, Kecamatan <?php echo isset($profil_data['kecamatan']) ? $profil_data['kecamatan'] : 'Data tidak tersedia'; ?>, <?php echo isset($profil_data['kabupaten']) ? $profil_data['kabupaten'] : 'Data tidak tersedia'; ?></a>, menerangkan dengan sebenarnya bahwa :
                    </td>
                </tr>
            </table>
            <br><br>
            <table width="100%" style="text-transform: capitalize;">
                <tr>
                    <td width="30%" class="indentasi">N&nbsp;&nbsp;&nbsp;A&nbsp;&nbsp;&nbsp;M&nbsp;&nbsp;&nbsp;A</td>
                    <td width="2%">:</td>
                    <td width="68%" style="text-transform: uppercase; font-weight: bold;"><?php echo isset($data['nama_pemilik']) ? $data['nama_pemilik'] : 'Data tidak tersedia'; ?></td>
                </tr>
                <tr>
                    <td class="indentasi">No Persil</td>
                    <td>:</td>
                    <td><?php echo isset($data['no_persil']) ? $data['no_persil'] : 'Data tidak tersedia'; ?></td>
                </tr>
                <tr>
                    <td class="indentasi">Alamat</td>
                    <td>:</td>
                    <td><?php echo isset($data['alamat_pemilik']) ? $data['alamat_pemilik'] : 'Data tidak tersedia'; ?></td>
                </tr>
                <tr>
                    <td class="indentasi">Kelas Desa</td>
                    <td>:</td>
                    <td><?php echo isset($data['kelas_desa']) ? $data['kelas_desa'] : 'Data tidak tersedia'; ?></td>
                </tr>
                <tr>
                    <td class="indentasi">Luas Tanah</td>
                    <td>:</td>
                    <td><?php echo isset($data['luas_milik']) ? $data['luas_milik'] . ' m<sup>2</sup>' : 'Data tidak tersedia'; ?></td>
                </tr>
                <tr>
                    <td class="indentasi">Jenis Tanah</td>
                    <td>:</td>
                    <td><?php echo isset($data['jenis_tanah']) ? $data['jenis_tanah'] : 'Data tidak tersedia'; ?></td>
                </tr>
            </table>
        </div>
        <br>
        <table width="100%">
            <tr>
                <td class="indentasi">Orang tersebut adalah benar-benar pemilik tanah yang sah atas sebidang tanah yang terletak di <a style="text-transform: capitalize;"> Desa <?php echo isset($profil_data['nama_desa']) ? $profil_data['nama_desa'] : 'Data tidak tersedia'; ?>, Kecamatan <?php echo isset($profil_data['kecamatan']) ? $profil_data['kecamatan'] : 'Data tidak tersedia'; ?>, <?php echo isset($profil_data['kabupaten']) ? $profil_data['kabupaten'] : 'Data tidak tersedia'; ?></a>. </td>
            </tr>
        </table><br>
        <table width="100%">
			<tr>
                <td class="indentasi">Surat keterangan ini dipergunakan untuk <a style="text-transform: capitalize;"><u><b><?php echo isset($data['keperluan']) ? $data['keperluan'] : 'Data tidak tersedia'; ?></b></u></a></td>
			</tr>
		</table><br>
		<table width="100%">
			<tr>
				<td class="indentasi">Demikian surat keterangan ini dibuat dengan sebenar-benarnya agar yang berkepentingan mengetahui dan untuk dipergunakan sebagaimana mestinya.</td>
			</tr>
		</table>
            
        <div align="right">
            <table width="100%">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="center"><br><br><br><br></td> <!-- Tambahkan elemen <br> tambahan untuk menurunkan teks -->
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="center"><br><br><br><br></td> <!-- Tambahkan elemen <br> tambahan untuk menurunkan teks -->
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="center"><br><br><br><br></td> <!-- Tambahkan elemen <br> tambahan untuk menurunkan teks -->
                </tr>
                
                <tr>
                    <td width="10%"></td>
                    <td width="30%"></td>
                    <td width="10%"></td>
                    <td align="center">
                        <?php echo isset($profil_data['nama_desa']) ? $profil_data['nama_desa'] : 'Data tidak tersedia'; ?>, 
                        <?php
                            $tanggal = date('d F Y');
                            $bulan = date('F', strtotime($tanggal));
                            $bulanIndo = array(
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
                            $tanggalIndo = date('d', strtotime($tanggal)) . ' ' . $bulanIndo[$bulan] . ' ' . date('Y', strtotime($tanggal));
                            echo $tanggalIndo;
                        ?>
                        <br>
                        <?php echo isset($data['jabatan']) ? $data['jabatan'] : 'Data tidak tersedia' ;?> <?php echo isset($profil_data['nama_desa']) ? $profil_data['nama_desa'] : 'Data tidak tersedia'; ?><br>
                        <br><br><br>
                        <u><?php echo isset($data['nama_pejabat_desa']) ? $data['nama_pejabat_desa'] : 'Data tidak tersedia';?> </u><br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <script>
        window.print(); // Memunculkan dialog print secara otomatis
    </script>
</body>
</html>