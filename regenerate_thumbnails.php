<?php
// Local DB connection
$conn = new mysqli('localhost', 'root', '', 'tpa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

$thumbnail_dir = "thumbnails/";
if (!is_dir($thumbnail_dir)) mkdir($thumbnail_dir, 0777, true);

$sql = "SELECT id, foto FROM galeri";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $foto_path = $row['foto'];
        $thumbnail_path = $thumbnail_dir . basename($foto_path);

        if (file_exists($foto_path) && !file_exists($thumbnail_path)) {
            buatThumbnail($foto_path, $thumbnail_path);
            echo "Thumbnail generated for " . $foto_path . "<br>";
        }

        // Update thumbnail column
        $update_sql = "UPDATE galeri SET thumbnail = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, 'si', $thumbnail_path, $row['id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    echo "Thumbnails regeneration completed.";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
