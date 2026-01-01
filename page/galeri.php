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
$sql = "SELECT id, judul, deskripsi, foto, thumbnail, tanggal_upload FROM galeri";
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
</head>
<body>
    <main class="container py-5">
        <h2 class="text-center mb-4">Galeri Kegiatan</h2>

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
        <div class="row">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-md-3 mb-4">';
                    echo '<div class="card">';
                    echo '<a href="../' . htmlspecialchars($row['foto']) . '" data-lightbox="galeri" data-title="' . htmlspecialchars($row['judul']) . '">';
                    echo '<img src="../' . htmlspecialchars($row['thumbnail']) . '" class="card-img-top" alt="' . htmlspecialchars($row['judul']) . '" style="object-fit: cover; height: 200px;">';
                    echo '</a>';
                    echo '<div class="text-center mt-2">';
                    echo '<h6 class="card-title mb-2">' . htmlspecialchars($row['judul']) . '</h6>';
                    echo '<a href="../admin/unduh_foto_galeri.php?file=' . urlencode($row['foto']) . '" class="btn btn-primary btn-sm">Unduh</a>';
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
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('../sw.js')
                .then(function(registration) {
                    console.log('Service Worker registered successfully:', registration);
                })
                .catch(function(error) {
                    console.log('Service Worker registration failed:', error);
                });
        }
    </script>
</body>
</html>
