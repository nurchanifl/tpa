<?php
include('../includes/koneksidb.php');

$file = $_GET['file'] ?? '';
if (empty($file)) {
    die("File tidak ditemukan.");
}

// Sanitize file path to prevent directory traversal
$file = basename($file);
$file_path = "../uploads/" . $file;

if (!file_exists($file_path)) {
    die("File tidak ditemukan.");
}

// Set headers for download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file_path));

// Read the file and output it
readfile($file_path);
exit;
?>
