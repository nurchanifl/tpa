<?php
include('../includes/koneksidb.php');
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

$id = intval($_GET['id']);
$query = "SELECT foto FROM galeri WHERE id = $id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $foto = $row['foto'];
    $thumbnail = $row['thumbnail'];
    // Hapus file foto jika ada
    if (file_exists($foto)) {
        unlink($foto);
    }
    // Hapus file thumbnail jika ada dan berbeda dari foto
    if (!empty($thumbnail) && $thumbnail !== $foto && file_exists($thumbnail)) {
        unlink($thumbnail);
    }

    // Hapus data dari database
    $delete_query = "DELETE FROM galeri WHERE id = $id";
    if (mysqli_query($conn, $delete_query)) {
        header('Location: galeri.php?msg=delete-success');
    } else {
        die("Error: " . mysqli_error($conn));
    }
} else {
    die("Foto tidak ditemukan.");
}
?>