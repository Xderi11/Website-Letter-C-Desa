<!DOCTYPE html>
<html>
<head>
  <title>Data Tanah</title>
  <style type="text/css">
    body {
      font-family: sans-serif;
      text-transform: capitalize;
    }
    table {
      margin: 20px auto;
      border-collapse: collapse;
      text-transform: capitalize;
    }
    table th, table td {
      border: 1px solid #3c3c3c;
      padding: 8px;
    }
    a {
      background: blue;
      color: #fff;
      padding: 8px 10px;
      text-decoration: none;
      border-radius: 2px;
    }
    .str {
      mso-number-format:\@;
    }
  </style>
</head>
<body>
  <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data Tanah Ds. Tanjung Berlian Barat.xls");
  ?>
  <center>
    <h2>Data Tanah Desa Tanjung Berlian Barat</h2>
  </center>
  <table border="1">
    <thead>
      <tr>
        <th><strong>No</strong></th>
        <th><strong>Nama Pemilik</strong></th>
        <th><strong>Alamat Pemilik</strong></th>
        <th><strong>No Persil</strong></th>
        <th><strong>Kelas Desa</strong></th>
        <th><strong>Luas Lahan</strong></th>
        <th><strong>Jenis Tanah</strong></th>
        <th><strong>Sebab Perubahan</strong></th>
      </tr>
    </thead>
    <tbody>
      <?php
        include ('../../config/koneksi.php');

        $no = 1;
        $qTampil = mysqli_query($connect, "SELECT * FROM tanah");
        while ($row = mysqli_fetch_array($qTampil)) {
      ?>
      <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $row['nama_pemilik']; ?></td>
        <td style="text-transform: capitalize;"><?php echo $row['alamat_pemilik']; ?></td>
        <td><?php echo $row['no_persil']; ?></td>
        <td style="text-transform: capitalize;"><?php echo $row['kelas_desa']; ?></td>
        <td style="text-transform: capitalize;"><?php echo $row['luas_milik']; ?></td>
        <td style="text-transform: capitalize;"><?php echo $row['jenis_tanah']; ?></td>
        <td style="text-transform: capitalize;"><?php echo $row['sebab_perubahan']; ?></td>
      </tr>
      <?php
        }
      ?>
    </tbody>
  </table>
</body>
</html>