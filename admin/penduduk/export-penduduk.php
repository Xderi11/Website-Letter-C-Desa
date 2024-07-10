<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<style type="text/css">
  	body{
  		font-family: sans-serif;
      text-transform: capitalize;
  	}
  	table{
  		margin: 20px auto;
  		border-collapse: collapse;
      text-transform: capitalize;
  	}
  	table th,
  	table td{
  		border: 1px solid #3c3c3c;
  		padding: 3px 8px;
   
  	}
  	a{
  		background: blue;
  		color: #fff;
  		padding: 8px 10px;
  		text-decoration: none;
  		border-radius: 2px;
  	}
    .str{ 
      mso-number-format:\@; 
    }
	</style>
	<?php
  	header("Content-type: application/vnd-ms-excel");
  	header("Content-Disposition: attachment; filename=Data Letter C Ds. Tanjung Berlian Barat.xls");
	?>
	<center>
		<h2>Data Letter C <br/> Desa Tanjung Berlian Barat</h2>
	</center>
	<table border="1">
    <thead>
      <tr>
        <th><strong>No</strong></th>
        <th><strong>Nama Pemilik</strong></th>
        <th><strong>Alamat Pemilik</strong></th>
        <th><strong>No Persil</strong></th>
        <th><strong>Kelas Desa</strong></th>
        <th><strong>Luas Milik</strong></th>
        <th><strong>Jenis Tanah</strong></th>
        <th><strong>Tanggal</strong></th>
        <th><strong>Sebab Perubahan</strong></th>
      </tr>
    </thead>
    <tbody>
      <?php
        include ('../../config/koneksi.php');

        $no = 1;
        $qTampil = mysqli_query($connect, "SELECT * FROM penduduk");
        foreach($qTampil as $row){
          $tanggal = $row['tanggal'];
      ?>
      <tr>
      <td><?php echo $no++; ?></td>
              <td><?php echo $row['nama_pemilik']; ?></td>
              <td style="text-transform: capitalize;"><?php echo $row['alamat_pemilik']; ?></td>
              <td style="text-transform: capitalize;"><?php echo $row['no_persil']; ?></td>
              <td style="text-transform: capitalize;"><?php echo $row['kelas_desa']; ?></td>
              <td style="text-transform: capitalize;"><?php echo $row['luas_milik']; ?></td>
              <td style="text-transform: capitalize;"><?php echo $row['jenis_tanah']; ?></td>
              <td style="text-transform: capitalize;">
              <?php
                $tanggal = date('d', strtotime($row['tanggal']));
                $bulan = date('F', strtotime($row['tanggal']));
                $tahun = date('Y', strtotime($row['tanggal']));
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
                  echo $tanggal . " " . $bulanIndo[$bulan] . " " . $tahun;
              ?>
              </td>

  
              <td style="text-transform: capitalize;"><?php echo $row['sebab_perubahan']; ?></td>
      </tr>
      <?php
        }
      ?>
    </tbody>    
  </table>
</body>
</html>