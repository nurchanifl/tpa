<?php
include('../includes/koneksidb.php');
include('../includes/navbar.php');

// Ambil semua kategori dari tabel galeri_kategori
$kategori_result = mysqli_query($conn, "SELECT * FROM galeri_kategori");
$kategori_list = [];
while ($row = mysqli_fetch_assoc($kategori_result)) {
    $kategori_list[] = $row['nama'];
}

// Fungsi membuat thumbnail
function buatThumbnail($src, $dest, $size = 400) {
    list($width, $height) = getimagesize($src);
    $image = imagecreatefromstring(file_get_contents($src));

    // Hitung crop untuk square
    $min_side = min($width, $height);
    $crop_x = ($width - $min_side) / 2;
    $crop_y = ($height - $min_side) / 2;

    // Crop image ke square
    $cropped = imagecrop($image, ['x' => $crop_x, 'y' => $crop_y, 'width' => $min_side, 'height' => $min_side]);

    // Resize ke size yang diinginkan
    $thumb = imagecreatetruecolor($size, $size);
    imagecopyresampled($thumb, $cropped, 0, 0, 0, 0, $size, $size, $min_side, $min_side);
    imagejpeg($thumb, $dest, 90); // Simpan thumbnail dengan kualitas 90%
    imagedestroy($thumb);
    imagedestroy($cropped);
    imagedestroy($image);
}

// Proses pengunggahan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);

    if (!empty($kategori_list) && !in_array($kategori, $kategori_list)) {
        die('<div class="alert alert-danger" role="alert">Kategori tidak valid!</div>');
    }

    $target_dir = "../uploads/";
    $thumbnail_dir = "../thumbnails/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    if (!is_dir($thumbnail_dir)) mkdir($thumbnail_dir, 0777, true);

    $errors = [];
    $success_count = 0;
    $foto_files = is_array($_FILES['foto']['name']) ? $_FILES['foto']['name'] : [$_FILES['foto']['name']];
    $tmp_names = is_array($_FILES['foto']['tmp_name']) ? $_FILES['foto']['tmp_name'] : [$_FILES['foto']['tmp_name']];
    $upload_errors = is_array($_FILES['foto']['error']) ? $_FILES['foto']['error'] : [$_FILES['foto']['error']];

    foreach ($foto_files as $key => $filename) {
        $foto = basename($filename);
        $tmp_name = $tmp_names[$key];
        $unique_id = time() . '_' . mt_rand(1000, 9999);
        $target_file = $target_dir . $unique_id . '_' . $foto;
        $thumbnail_file = $thumbnail_dir . $unique_id . '_' . $foto;

        if (empty($foto)) {
            continue;
        }

        if ($upload_errors[$key] !== UPLOAD_ERR_OK) {
            switch ($upload_errors[$key]) {
                case UPLOAD_ERR_INI_SIZE:
                    $errors[] = "File $foto terlalu besar (melebihi upload_max_filesize).";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $errors[] = "File $foto terlalu besar (melebihi MAX_FILE_SIZE).";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errors[] = "File $foto hanya terunggah sebagian.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errors[] = "Tidak ada file yang dipilih untuk $foto.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $errors[] = "Folder temporary tidak ditemukan.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $errors[] = "Gagal menulis file $foto ke disk.";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $errors[] = "Upload file $foto dihentikan oleh ekstensi.";
                    break;
                default:
                    $errors[] = "Error tidak diketahui untuk $foto.";
                    break;
            }
            continue;
        }

        if (empty($tmp_name)) {
            $errors[] = "File $foto gagal diunggah.";
            continue;
        }

        if (getimagesize($tmp_name) === false) {
            $errors[] = "File $foto bukan gambar valid.";
            continue;
        }

        if (move_uploaded_file($tmp_name, $target_file)) {
            if (function_exists('imagecreatetruecolor')) {
                buatThumbnail($target_file, $thumbnail_file); // Buat thumbnail
            } else {
                $thumbnail_file = $target_file; // Jika GD tidak tersedia, gunakan file asli
            }

            $sql = "INSERT INTO galeri (judul, deskripsi, kategori, foto, thumbnail, tanggal_upload)
                    VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'sssss', $judul, $deskripsi, $kategori, $target_file, $thumbnail_file);

            if (mysqli_stmt_execute($stmt)) {
                $success_count++;
            } else {
                $errors[] = "Gagal menyimpan $foto ke database.";
            }

            mysqli_stmt_close($stmt);
        } else {
            $errors[] = "Gagal mengunggah file $foto.";
        }
    }

    if ($success_count > 0) {
        echo '<div class="alert alert-success">' . $success_count . ' file berhasil diunggah!</div>';
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Folder ke Galeri</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-4">Unggah Folder ke Galeri</h1>
        <form action="upload_galeri.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-select" id="kategori" name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategori_list as $kategori): ?>
                        <option value="<?= htmlspecialchars($kategori) ?>"><?= htmlspecialchars($kategori) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Pilih Tipe Upload</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="upload_type" id="single" value="single" checked>
                    <label class="form-check-label" for="single">
                        Upload File Tunggal
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="upload_type" id="multiple" value="multiple">
                    <label class="form-check-label" for="multiple">
                        Upload Beberapa File
                    </label>
                </div>
            </div>
            <div class="mb-3" id="single-file-div">
                <label for="foto_single" class="form-label">Pilih File Foto</label>
                <input type="file" class="form-control" id="foto_single" name="foto" accept="image/*" required>
            </div>
            <div class="mb-3" id="multiple-div" style="display: none;">
                <label for="foto_multiple" class="form-label">Pilih Beberapa File Foto</label>
                <input type="file" class="form-control" id="foto_multiple" name="foto[]" accept="image/*" multiple required>
            </div>
            <button type="submit" class="btn btn-primary" id="upload-btn">Unggah</button>
            <div id="loading" style="display: none;" class="mt-3">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span>Mengunggah file, harap tunggu...</span>
            </div>
        </form>
        <script>
            document.querySelectorAll('input[name="upload_type"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'single') {
                        document.getElementById('single-file-div').style.display = 'block';
                        document.getElementById('multiple-div').style.display = 'none';
                        document.getElementById('foto_single').required = true;
                        document.getElementById('foto_multiple').required = false;
                    } else {
                        document.getElementById('single-file-div').style.display = 'none';
                        document.getElementById('multiple-div').style.display = 'block';
                        document.getElementById('foto_single').required = false;
                        document.getElementById('foto_multiple').required = true;
                    }
                });
            });

            document.getElementById('upload-btn').addEventListener('click', function() {
                document.getElementById('loading').style.display = 'block';
                this.disabled = true;
            });
        </script>
    </div>
</body>
</html>