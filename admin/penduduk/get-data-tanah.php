<?php
include ('../../config/koneksi.php');

// Pastikan request POST berisi no_persil
if(isset($_POST['no_persil'])) {
    $no_persil = $_POST['no_persil'];
    
    // Query untuk mencari data tanah berdasarkan no_persil
    $query = "SELECT * FROM tanah WHERE no_persil = '$no_persil'";
    $result = mysqli_query($connect, $query);

    // Periksa apakah query berhasil dieksekusi
    if (!$result) {
        // Jika query gagal dieksekusi, kirimkan pesan error
        echo json_encode(['error' => 'Query Error: ' . mysqli_error($connect)]);
    } else {
        // Jika data ditemukan, kirimkan sebagai respons JSON
        if(mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            echo json_encode($data);
        } else {
            // Jika data tidak ditemukan, kirimkan pesan error
            echo json_encode(['error' => 'Data tidak ditemukan']);
        }
    }
} else {
    // Jika no_persil tidak disediakan dalam request POST
    echo json_encode(['error' => 'No Persil Sudah ada']);
}

// Tutup koneksi database
mysqli_close($connect);
?>