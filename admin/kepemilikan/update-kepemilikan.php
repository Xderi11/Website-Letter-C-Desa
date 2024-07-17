<?php 
session_start();
include ('../../config/koneksi.php');
include ('../part/header.php');

if(isset($_POST['submit'])) {
    $id = $_POST['id'] ?? '';
    $tanggal_perubahan = $_POST['ftanggal_perubahan'] ?? '';
    $sebab_perubahan = $_POST['fsebab_perubahan'] ?? '';
    $status_kepemilikan = $_POST['fstatus_kepemilikan'] ?? '';

    // Siapkan query untuk update data di kepemilikan_letter_c
    $query_update = "
        UPDATE kepemilikan_letter_c 
        SET tanggal_perubahan = ?, sebab_perubahan = ?, status_kepemilikan = ?
        WHERE id_kepemilikan = ?
    ";

    $stmt_update = $connect->prepare($query_update);
    $stmt_update->bind_param("sssi", $tanggal_perubahan, $sebab_perubahan, $status_kepemilikan, $id);

    if ($stmt_update->execute()) {
        $_SESSION['success_message'] = "Data Letter C berhasil diperbarui.";
        header("Location: ../kepemilikan/");
        exit;
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui data Letter C: " . $stmt_update->error;
        header("Location: update-kepemilikan.php?id=$id");
        exit;
    }
}

$id = $_GET['id'] ?? '';
$qCek = mysqli_query($connect,"SELECT * FROM kepemilikan_letter_c WHERE id_kepemilikan='$id'");
$row = mysqli_fetch_assoc($qCek);

include ('../part/footer.php');
?>