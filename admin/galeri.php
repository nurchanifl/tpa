<?php 
session_start();
include('../includes/koneksidb.php');
include('../includes/navbar.php');

// Default nilai untuk pagination
$limit = 9;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Ambil daftar kategori dari database
$kategori_list = [];
$kategori_query = "SELECT nama FROM galeri_kategori ORDER BY nama ASC";
$kategori_result = mysqli_query($conn, $kategori_query);
if ($kategori_result) {
    while ($row = mysqli_fetch_assoc($kategori_result)) {
        $kategori_list[] = $row['nama'];
    }
}

// Filter kategori
$kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($conn, $_GET['kategori']) : '';
$sql = "SELECT * FROM galeri";
if ($kategori != '') {
    $sql .= " WHERE kategori = '$kategori'";
}
$sql .= " ORDER BY tanggal_upload DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

// Hitung total data untuk pagination
$total_sql = "SELECT COUNT(*) AS total FROM galeri";
if ($kategori != '') {
    $total_sql .= " WHERE kategori = '$kategori'";
}
$total_result = mysqli_query($conn, $total_sql);
$total = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total / $limit);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Kegiatan</title>
    <link href="../assets/lightbox/css/lightbox.min.css" rel="stylesheet">
    <script src="../assets/lightbox/js/lightbox.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .card-img-top {
            max-width: 100%;
            max-height: 150px;
            width: auto;
            height: auto;
        }
        .card {
            overflow: hidden;
        }
        .card-img-top {
            width: 100%;
            max-height: 150px;
            object-fit: cover;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: auto;
        }
        .btn-container {
            margin-top: auto;
        }
    </style>
</head>
<body>
    <header class="bg-primary text-white py-3">
        <div class="container">
            <h1 class="text-center">Galeri Kegiatan</h1>
        </div>
    </header>
    <main class="container py-5">

        <!-- Filter Form -->
        <form method="GET">
            <select name="kategori" class="form-select mb-4" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori_list as $kategori_item): ?>
                    <option value="<?= htmlspecialchars($kategori_item) ?>" <?= $kategori == $kategori_item ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kategori_item) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
        
        <!-- Gallery Grid -->
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-6">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-md-4 mb-2">';
                    echo '<div class="card">';
                    $img_src = !empty($row['thumbnail']) ? '../' . $row['thumbnail'] : '../' . $row['foto'];
                    echo '<a href="../' . htmlspecialchars($row['foto']) . '" data-lightbox="galeri" data-title="' . htmlspecialchars($row['judul']) . '">';
                    echo '<img src="' . htmlspecialchars($img_src) . '" class="card-img-top" alt="' . htmlspecialchars($row['judul']) . '">';
                    echo '</a>';
                    echo '<div class="card-body p-2">';
                    echo '<h6 class="card-title">' . htmlspecialchars($row['judul']) . '</h6>';
                    echo '<small class="card-text">' . htmlspecialchars($row['deskripsi']) . '</small>';

                    // Tombol
                    echo '<div class="btn-container d-flex justify-content-center gap-1 mt-auto">';
                    echo '<a href="unduh_foto_galeri.php?file=' . urlencode($row['foto']) . '" class="btn btn-primary btn-sm">Unduh</a>';
                    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                        echo '<a href="edit_galeri.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a>';
                        echo '<a href="hapus_galeri.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus foto ini?\')">Hapus</a>';
                    }
                    echo '</div>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12"><p class="text-center">Belum ada foto yang diunggah.</p></div>';
            }
            ?>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = $i == $page ? 'active' : '';
                    $kategori_param = $kategori != '' ? '&kategori=' . urlencode($kategori) : '';
                    echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . $kategori_param . '">' . $i . '</a></li>';
                }
                ?>
            </ul>
        </nav>
    </main>
    <footer class="mt-5">
        <?php include '../includes/footer.php'; ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>