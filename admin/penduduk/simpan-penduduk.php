<?php
session_start();
include('../../config/koneksi.php');

if (isset($_POST['submit'])) {
    $nama_pemilik = $_POST['fnama_pemilik'] ?? '';
    $alamat_pemilik = $_POST['falamat_pemilik'] ?? '';
    $no_persil = $_POST['fno_persil'] ?? '';
    $kelas_desa = $_POST['fkelas_desa'] ?? '';
    $luas_milik = $_POST['fluas_milik'] ?? '';
    $jenis_tanah = $_POST['fjenis_tanah'] ?? '';
    $tanggal = $_POST['ftanggal'] ?? '';
    $pajak_bumi = str_replace('.', '', $_POST['fpajak_bumi']) ?? ''; // Menghapus titik sebagai pemisah ribuan
    $keterangan_tanah = $_POST['fketerangan_tanah'] ?? '';

    // Nilai default untuk kolom tambahan di tabel pemilik
    $tanggal_perubahan = $_POST['ftanggal_perubahan'] ?? null;
    $sebab_perubahan = $_POST['fsebab_perubahan'] ?? null;
    $status_kepemilikan = $_POST['fstatus_kepemilikan'] ?? null;

    // Mulai transaksi
    $connect->begin_transaction();

    try {
        // Siapkan query untuk memasukkan data baru ke kepemilikan_letter_c
        $query_insert_letter_c = "
            INSERT INTO kepemilikan_letter_c (nama_pemilik, alamat_pemilik, no_persil, kelas_desa, luas_milik, jenis_tanah, tanggal, pajak_bumi, keterangan_tanah)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt_insert_letter_c = $connect->prepare($query_insert_letter_c);
        $stmt_insert_letter_c->bind_param("sssssssss", $nama_pemilik, $alamat_pemilik, $no_persil, $kelas_desa, $luas_milik, $jenis_tanah, $tanggal, $pajak_bumi, $keterangan_tanah);

        // Eksekusi query untuk kepemilikan_letter_c
        if ($stmt_insert_letter_c->execute() === false) {
            throw new Exception("Gagal menambahkan data ke kepemilikan_letter_c: " . $stmt_insert_letter_c->error);
        }

        // Ambil id_kepemilikan yang baru saja dimasukkan
        $id_kepemilikan = $stmt_insert_letter_c->insert_id;

        // Siapkan query untuk memasukkan data baru ke pemilik
        $query_insert_pemilik = "
            INSERT INTO pemilik (id_kepemilikan, nama_pemilik, no_persil, alamat_pemilik, tanggal, keterangan_tanah, tanggal_perubahan, sebab_perubahan, status_kepemilikan)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt_insert_pemilik = $connect->prepare($query_insert_pemilik);
        
        // Bind parameters with null handling
        $stmt_insert_pemilik->bind_param("issssssss", $id_kepemilikan, $nama_pemilik, $no_persil, $alamat_pemilik, $tanggal, $keterangan_tanah, $tanggal_perubahan, $sebab_perubahan, $status_kepemilikan);

        // Eksekusi query untuk pemilik
        if ($stmt_insert_pemilik->execute() === false) {
            throw new Exception("Gagal menambahkan data ke pemilik: " . $stmt_insert_pemilik->error);
        }

        // Komit transaksi
        $connect->commit();
        $_SESSION['success_message'] = "Data Letter C berhasil ditambahkan.";
        header("Location: index.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        $connect->rollback();
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: tambah-penduduk.php");
        exit;
    }
}

mysqli_close($connect);
?>