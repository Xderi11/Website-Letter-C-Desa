<?php
// Mulai sesi untuk menangani pesan flash
session_start();

// Koneksi ke database
include('../../config/koneksi.php');

// Periksa apakah form telah disubmit
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nik = $_POST['nik'];
    $nama_pemilik = $_POST['nama_pemilik'];
    $no_persil = $_POST['no_persil'];
    $alamat_pemilik = $_POST['alamat_pemilik'];
    $kelas_desa = $_POST['kelas_desa'];
    $luas_milik = $_POST['luas_milik'];
    $jenis_tanah = $_POST['jenis_tanah'];
    $tanggal = $_POST['tanggal'];
    $pajak_bumi = $_POST['pajak_bumi'];
    $keterangan_tanah = $_POST['keterangan_tanah'];
    $tanggal_perubahan = $_POST['tanggal_perubahan'];
    $sebab_perubahan = $_POST['sebab_perubahan'];
    $status_kepemilikan = $_POST['status_kepemilikan'];
    $saksi = $_POST['saksi'];
    $notaris = $_POST['notaris'];

    // Query untuk mendapatkan id_kepemilikan dari tabel kepemilikan_letter_c
    $query_get_id_kepemilikan = "SELECT id_kepemilikan FROM kepemilikan_letter_c WHERE nik = ? AND no_persil = ?";
    if ($stmt_get_id = mysqli_prepare($connect, $query_get_id_kepemilikan)) {
        mysqli_stmt_bind_param($stmt_get_id, 'ss', $nik, $no_persil);
        mysqli_stmt_execute($stmt_get_id);
        mysqli_stmt_bind_result($stmt_get_id, $id_kepemilikan);
        mysqli_stmt_fetch($stmt_get_id);
        mysqli_stmt_close($stmt_get_id);
    } else {
        $_SESSION['error_message'] = "Gagal mendapatkan ID kepemilikan: " . mysqli_error($connect);
        header("Location: index.php");
        exit();
    }

    if (!$id_kepemilikan) {
        $_SESSION['error_message'] = "ID kepemilikan tidak ditemukan.";
        header("Location: index.php");
        exit();
    }

    // Periksa apakah ada entri aktif dengan nomor persil yang sama
    if ($status_kepemilikan === 'aktif') {
        $query_check_pemilik = "SELECT id_pemilik FROM pemilik WHERE no_persil = ? AND status_kepemilikan = 'aktif'";
        if ($stmt_check_pemilik = mysqli_prepare($connect, $query_check_pemilik)) {
            mysqli_stmt_bind_param($stmt_check_pemilik, 's', $no_persil);
            mysqli_stmt_execute($stmt_check_pemilik);
            mysqli_stmt_store_result($stmt_check_pemilik);

            if (mysqli_stmt_num_rows($stmt_check_pemilik) > 0) {
                $_SESSION['error_message'] = "Nomor persil sudah aktif di tabel pemilik. Anda harus menonaktifkan data tersebut terlebih dahulu.";
                mysqli_stmt_close($stmt_check_pemilik);
                header("Location: index.php");
                exit();
            }

            mysqli_stmt_close($stmt_check_pemilik);
        } else {
            $_SESSION['error_message'] = "Gagal memeriksa data di tabel pemilik: " . mysqli_error($connect);
            header("Location: index.php");
            exit();
        }
    }

    // Query untuk memasukkan data ke tabel perubahan
    $query_insert_perubahan = "INSERT INTO perubahan (id_kepemilikan, nik, nama_pemilik, no_persil, alamat_pemilik, kelas_desa, luas_milik, jenis_tanah, tanggal, pajak_bumi, keterangan_tanah, tanggal_perubahan, sebab_perubahan, status_kepemilikan, saksi, notaris)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Siapkan statement untuk perubahan
    if ($stmt = mysqli_prepare($connect, $query_insert_perubahan)) {
        // Bind parameter
        mysqli_stmt_bind_param($stmt, 'isssssssssssssss', $id_kepemilikan, $nik, $nama_pemilik, $no_persil, $alamat_pemilik, $kelas_desa, $luas_milik, $jenis_tanah, $tanggal, $pajak_bumi, $keterangan_tanah, $tanggal_perubahan, $sebab_perubahan, $status_kepemilikan, $saksi, $notaris);

        // Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Set pesan sukses
            $_SESSION['success_message'] = "Data berhasil disimpan.";

            // Jika status kepemilikan aktif, simpan ke tabel pemilik
            if ($status_kepemilikan === 'aktif') {
                // Query untuk mendapatkan id_pemilik berikutnya
                $query_get_id_pemilik = "SELECT COALESCE(MAX(id_pemilik), 0) + 1 FROM pemilik";
                $result_id_pemilik = mysqli_query($connect, $query_get_id_pemilik);
                $id_pemilik = mysqli_fetch_array($result_id_pemilik)[0];

                // Query untuk memasukkan data ke tabel pemilik
                $query_insert_pemilik = "INSERT INTO pemilik (id_pemilik, nik, id_kepemilikan, nama_pemilik, alamat_pemilik, no_persil, tanggal, keterangan_tanah, tanggal_perubahan, sebab_perubahan, status_kepemilikan, saksi, notaris)
                                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                // Siapkan statement untuk pemilik
                if ($stmt_pemilik = mysqli_prepare($connect, $query_insert_pemilik)) {
                    // Bind parameter
                    mysqli_stmt_bind_param($stmt_pemilik, 'issssssssssss', $id_pemilik, $nik, $id_kepemilikan, $nama_pemilik, $alamat_pemilik, $no_persil, $tanggal, $keterangan_tanah, $tanggal_perubahan, $sebab_perubahan, $status_kepemilikan, $saksi, $notaris);

                    // Eksekusi statement
                    if (!mysqli_stmt_execute($stmt_pemilik)) {
                        $_SESSION['error_message'] = "Gagal menyimpan data ke tabel pemilik: " . mysqli_stmt_error($stmt_pemilik);
                    }

                    // Tutup statement pemilik
                    mysqli_stmt_close($stmt_pemilik);
                } else {
                    $_SESSION['error_message'] = "Gagal mempersiapkan statement untuk tabel pemilik: " . mysqli_error($connect);
                }
            } else {
                // Jika status kepemilikan tidak aktif, hapus entri terkait di tabel pemilik
                $query_delete_pemilik = "DELETE FROM pemilik WHERE no_persil = ? AND status_kepemilikan = 'aktif'";
                if ($stmt_delete_pemilik = mysqli_prepare($connect, $query_delete_pemilik)) {
                    mysqli_stmt_bind_param($stmt_delete_pemilik, 's', $no_persil);

                    if (!mysqli_stmt_execute($stmt_delete_pemilik)) {
                        $_SESSION['error_message'] = "Gagal menghapus data dari tabel pemilik: " . mysqli_stmt_error($stmt_delete_pemilik);
                    }

                    mysqli_stmt_close($stmt_delete_pemilik);
                } else {
                    $_SESSION['error_message'] = "Gagal mempersiapkan statement untuk menghapus data dari tabel pemilik: " . mysqli_error($connect);
                }
            }
        } else {
            // Set pesan error
            $_SESSION['error_message'] = "Gagal menyimpan data ke tabel perubahan: " . mysqli_stmt_error($stmt);
        }

        // Tutup statement perubahan
        mysqli_stmt_close($stmt);
    } else {
        // Set pesan error
        $_SESSION['error_message'] = "Gagal mempersiapkan statement untuk tabel perubahan: " . mysqli_error($connect);
    }

    // Tutup koneksi
    mysqli_close($connect);

    // Redirect ke halaman index.php
    header("Location: index.php");
    exit();
} else {
    // Jika form tidak disubmit, redirect ke halaman index.php
    header("Location: index.php");
    exit();
}
?>
