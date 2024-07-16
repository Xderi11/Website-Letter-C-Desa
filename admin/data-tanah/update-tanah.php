<?php
include('../../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tanah = $_POST['id_tanah'];
    $no_persil = $_POST['fno_persil'];
    $kelas_desa = $_POST['fkelas_desa'];
    $luas_milik = $_POST['fluas_milik'];
    $jenis_tanah = $_POST['fjenis_tanah'];
    $pajak_bumi = $_POST['fpajak_bumi'];
    $keterangan_tanah = $_POST['fketerangan_tanah'];

    // Cek apakah nomor persil sudah ada di database selain untuk data yang sedang diedit
    $queryCheck = "SELECT id_tanah FROM tanah WHERE no_persil = '$no_persil' AND id_tanah != $id_tanah";
    $resultCheck = mysqli_query($connect, $queryCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
        // Jika nomor persil sudah ada di database (selain untuk data yang sedang diedit)
        $alert_message = "Nomor persil sudah ada di database.";
        $alert_class = "alert-danger";
    } else {
        // Query untuk update data
        $query = "UPDATE tanah SET 
                  no_persil = '$no_persil', 
                  kelas_desa = '$kelas_desa', 
                  luas_milik = '$luas_milik', 
                  jenis_tanah = '$jenis_tanah', 
                  pajak_bumi = '$pajak_bumi', 
                  keterangan_tanah = '$keterangan_tanah' 
                  WHERE id_tanah = $id_tanah";

        if (mysqli_query($connect, $query)) {
            mysqli_close($connect);
            $alert_message = "Data tanah berhasil diubah.";
            $alert_class = "alert-success";
        } else {
            $alert_message = "Ada masalah dengan input data.";
            $alert_class = "alert-danger";
        }
    }
} else {
    echo "Metode permintaan tidak valid.";
}
?>