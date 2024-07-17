<?php
// Koneksi ke database
include('../../config/koneksi.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Query untuk mengambil data kepemilikan berdasarkan id
    $query = "SELECT nama_pemilik, no_persil, tanggal, keterangan_tanah FROM kepemilikan_letter_c WHERE id_kepemilikan = '$id'";
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $data = array(
            'nama_pemilik' => $row['nama_pemilik'],
            'no_persil' => $row['no_persil'],
            'tanggal' => $row['tanggal'],
            'keterangan_tanah' => $row['keterangan_tanah']
        );
        echo json_encode($data);
    } else {
        $data = array('error' => 'Data tidak ditemukan');
        echo json_encode($data);
    }
} else {
    $data = array('error' => 'ID tidak ditemukan');
    echo json_encode($data);
}

// Tutup koneksi database
mysqli_close($connect);
?>