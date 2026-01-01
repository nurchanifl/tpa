<?php
include('../includes/koneksidb.php');
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Ambil semua kategori dari tabel galeri_kategori
$kategori_result = mysqli_query($conn, "SELECT * FROM galeri_kategori");
$kategori_list = [];
while ($row = mysqli_fetch_assoc($kategori_result)) {
    $kategori_list[] = $row['nama'];
}

$id = intval($_GET['id']);
$query = "SELECT * FROM galeri WHERE id = $id";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) {
    die("Foto tidak ditemukan.");
}
$foto = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);

    if (!empty($kategori_list) && !in_array($kategori, $kategori_list)) {
        die('Kategori tidak valid!');
    }

    $update_query = "UPDATE galeri SET judul = '$judul', deskripsi = '$deskripsi', kategori = '$kategori' WHERE id = $id";
    if (mysqli_query($conn, $update_query)) {
        header('Location: galeri.php?msg=update-success');
    } else {
        die("Error: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Galeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Foto Galeri</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" id="judul" name="judul" class="form-control" value="<?= htmlspecialchars($foto['judul']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5" required><?= htmlspecialchars($foto['deskripsi']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-select" id="kategori" name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategori_list as $kategori): ?>
                        <option value="<?= htmlspecialchars($kategori) ?>" <?= $foto['kategori'] == $kategori ? 'selected' : '' ?>><?= htmlspecialchars($kategori) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="galeri.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>