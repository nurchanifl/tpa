<?php
session_start();
include('includes/koneksidb.php');
include('includes/navbar.php'); 

?>
<?php
// Periksa apakah pengguna login
 $is_logged_in = isset($_SESSION['id']);

// Dapatkan nama file saat ini
$current_page = basename($_SERVER['PHP_SELF']);

if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TPA - Beranda</title>
    <link rel="manifest" href="manifest.json">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
    

    </header>
    <section class="hero bg-primary text-white text-center py-5">
    <div class="container">
        <h1>Selamat Datang di TPA</h1>
        <p>Kami berkomitmen memberikan pendidikan terbaik untuk anak-anak.</p>
    </div>
</section>

    <main class="container py-5">
        <p>Ini adalah website resmi TPA. Di sini Anda bisa melihat informasi kegiatan, jadwal, dan berita terbaru.</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kegiatan</h5>
                        <p class="card-text">Lihat berbagai kegiatan menarik di TPA.</p>
                        <a href="page/activities.php" class="btn btn-primary">Lihat Kegiatan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jadwal</h5>
                        <p class="card-text">Cek jadwal terbaru kegiatan di TPA.</p>
                        <a href="page/schedule.php" class="btn btn-primary">Lihat Jadwal</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kontak Kami</h5>
                        <p class="card-text">Hubungi kami untuk informasi lebih lanjut.</p>
                        <a href="page/contact.php" class="btn btn-primary">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

        <!-- Gallery Section -->
        <section class="gallery-section py-5">
            <div class="container">
                <h2 class="text-center mb-4">Galeri Kegiatan</h2>
                <div class="row">
                    <?php
                    // Ambil 3 foto galeri terbaru
                    $sql_galeri = "SELECT thumbnail, judul FROM galeri ORDER BY tanggal_upload DESC LIMIT 3";
                    $result_galeri = mysqli_query($conn, $sql_galeri);
                    if ($result_galeri && mysqli_num_rows($result_galeri) > 0) {
                        while ($row = mysqli_fetch_assoc($result_galeri)) {
                            echo '<div class="col-md-4 mb-4">';
                            echo '<img src="' . htmlspecialchars($row['thumbnail']) . '" alt="' . htmlspecialchars($row['judul']) . '" class="img-fluid rounded shadow gallery-img" style="object-fit: cover; height: 200px;">';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="col-12"><p class="text-center">Belum ada foto galeri.</p></div>';
                    }
                    ?>
                </div>
                <div class="text-center">
                    <a href="page/galeri.php" class="btn btn-secondary">Lihat Lebih Banyak</a>
                </div>
            </div>
        </section>

    <a href="page/testimoni.php" class="sticky-testimoni">
        <i class="fas fa-comment-dots"></i> Lihat Testimoni
    </a>

    <footer>
        <?php include 'includes/footer.php';?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
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
