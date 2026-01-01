-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Okt 2025 pada 13.59
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpa_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT current_timestamp(),
  `kategori` varchar(100) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `galeri`
--

INSERT INTO `galeri` (`id`, `judul`, `foto`, `deskripsi`, `tanggal_upload`, `kategori`, `thumbnail`) VALUES
(3, 'foto bersama', 'uploads/1733693793_DSC09220.JPG', 'bagus', '2024-12-08 21:36:33', 'Kegiatan', NULL),
(4, 'foto bersama', '../uploads/1759840758_DSC09152.JPG', 'rewrew', '2025-10-07 12:39:20', 'Lomba Unit 2024', '../thumbnails/1759840758_DSC09152.JPG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri_kategori`
--

CREATE TABLE `galeri_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `galeri_kategori`
--

INSERT INTO `galeri_kategori` (`id`, `nama`) VALUES
(1, 'Rihlah 2025'),
(2, 'Lomba Unit 2024');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hari_libur`
--

CREATE TABLE `hari_libur` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hari_libur`
--

INSERT INTO `hari_libur` (`id`, `tanggal`, `keterangan`) VALUES
(1, '2024-12-12', 'Maulid Nabi'),
(2, '2024-12-25', 'Libur Natal'),
(3, '2024-01-01', 'Tahun Baru');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_kegiatan`
--

CREATE TABLE `jadwal_kegiatan` (
  `id` int(11) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `tempat` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_kegiatan`
--

INSERT INTO `jadwal_kegiatan` (`id`, `nama_kegiatan`, `tanggal`, `waktu`, `tempat`, `deskripsi`) VALUES
(2, 'pengajian Semester Baru', '2025-01-03', '03:30:00', 'GDA', 'Pengajian Menyambut Semester Baru');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `id_unit` int(11) DEFAULT NULL,
  `nama_kelas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `id_unit`, `nama_kelas`) VALUES
(1, 1, 'Kelas A'),
(2, 1, 'Kelas B'),
(3, 1, 'Kelas C'),
(4, 1, 'Kelas D'),
(5, 1, 'Kelas E'),
(6, 1, 'Kelas F'),
(7, 2, 'Kelas A'),
(8, 2, 'Kelas B'),
(9, 2, 'Kelas C'),
(10, 2, 'Kelas D'),
(11, 2, 'Kelas E'),
(12, 2, 'Kelas F'),
(13, 3, 'Kelas A'),
(14, 3, 'Kelas B'),
(15, 3, 'Kelas C');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal_kirim` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kontak`
--

INSERT INTO `kontak` (`id`, `nama`, `email`, `pesan`, `tanggal_kirim`) VALUES
(1, 'nur', 'nurchanief@gmail.com', 'tpa yang bagus', '2024-12-08 16:07:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran_santri`
--

CREATE TABLE `pendaftaran_santri` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `isi`, `tanggal_dibuat`) VALUES
(1, 'Libur semester', 'Terkait jadwal libur semester 1 dari tanggal 22 desember sampai tanggal 04 januari, dan masuk kembali tanggal 05 januari', '2024-12-08 16:30:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `id_santri` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id`, `id_santri`, `tanggal`, `status`, `keterangan`) VALUES
(288, 1, '2024-12-13', 'Hadir', ''),
(289, 7, '2024-12-13', 'Hadir', ''),
(290, 8, '2024-12-13', 'Hadir', ''),
(291, 9, '2024-12-13', 'Hadir', ''),
(292, 10, '2024-12-13', 'Sakit', ''),
(293, 11, '2024-12-13', 'Hadir', ''),
(294, 1, '2024-12-02', 'Sakit', ''),
(295, 7, '2024-12-02', 'Hadir', ''),
(296, 8, '2024-12-02', 'Hadir', ''),
(297, 9, '2024-12-02', 'Hadir', ''),
(298, 10, '2024-12-02', 'Hadir', ''),
(299, 11, '2024-12-02', 'Hadir', ''),
(300, 1, '2024-12-03', 'Hadir', ''),
(301, 7, '2024-12-03', 'Hadir', ''),
(302, 8, '2024-12-03', 'Hadir', ''),
(303, 9, '2024-12-03', 'Hadir', ''),
(304, 10, '2024-12-03', 'Hadir', ''),
(305, 11, '2024-12-03', 'Hadir', ''),
(306, 1, '2024-12-04', 'Hadir', ''),
(307, 7, '2024-12-04', 'Hadir', ''),
(308, 8, '2024-12-04', 'Hadir', ''),
(309, 9, '2024-12-04', 'Hadir', ''),
(310, 10, '2024-12-04', 'Izin', ''),
(311, 11, '2024-12-04', 'Hadir', ''),
(318, 1, '2024-12-05', 'Hadir', ''),
(319, 7, '2024-12-05', 'Hadir', ''),
(320, 8, '2024-12-05', 'Hadir', ''),
(321, 9, '2024-12-05', 'Hadir', ''),
(322, 10, '2024-12-05', 'Hadir', ''),
(323, 11, '2024-12-05', 'Alpha', ''),
(324, 6, '2024-12-14', 'Hadir', ''),
(325, 12, '2024-12-14', 'Hadir', ''),
(326, 13, '2024-12-14', 'Hadir', ''),
(327, 14, '2024-12-14', 'Hadir', ''),
(328, 15, '2024-12-14', 'Hadir', ''),
(329, 16, '2024-12-14', 'Hadir', ''),
(336, 6, '2024-12-13', 'Hadir', ''),
(337, 12, '2024-12-13', 'Hadir', ''),
(338, 13, '2024-12-13', 'Hadir', ''),
(339, 14, '2024-12-13', 'Hadir', ''),
(340, 15, '2024-12-13', 'Hadir', ''),
(341, 16, '2024-12-13', 'Sakit', ''),
(342, 6, '2025-10-06', 'Izin', ''),
(343, 12, '2025-10-06', 'Hadir', ''),
(344, 13, '2025-10-06', 'Hadir', ''),
(345, 14, '2025-10-06', 'Sakit', ''),
(346, 15, '2025-10-06', 'Hadir', ''),
(347, 16, '2025-10-06', 'Hadir', ''),
(354, 6, '2025-10-07', 'Hadir', ''),
(355, 12, '2025-10-07', 'Hadir', ''),
(356, 13, '2025-10-07', 'Hadir', ''),
(357, 14, '2025-10-07', 'Hadir', ''),
(358, 15, '2025-10-07', 'Hadir', ''),
(359, 16, '2025-10-07', 'Hadir', ''),
(360, 6, '2025-10-08', 'Hadir', ''),
(361, 12, '2025-10-08', 'Hadir', ''),
(362, 13, '2025-10-08', 'Izin', ''),
(363, 14, '2025-10-08', 'Hadir', ''),
(364, 15, '2025-10-08', 'Sakit', ''),
(365, 16, '2025-10-08', 'Hadir', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating_testimoni`
--

CREATE TABLE `rating_testimoni` (
  `id` int(11) NOT NULL,
  `pengguna_id` int(11) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `testimoni` longtext DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rating_testimoni`
--

INSERT INTO `rating_testimoni` (`id`, `pengguna_id`, `nama_pengguna`, `rating`, `testimoni`, `tanggal`) VALUES
(10, 1, 'Anonym', 5, 'bagus\\r\\nkeren', '2024-12-08 21:52:34'),
(11, 1, 'Anonym', 1, 'loh\\r\\nlah', '2024-12-08 22:00:09'),
(12, 1, 'Anonym', 1, 'jelek\\r\\nbaget', '2024-12-08 22:02:48'),
(13, 1, 'Anonym', 1, 'aku\r\nsuka\r\nbakso', '2024-12-08 22:04:15'),
(14, 1, 'Anonym', 3, 'coba katakan saja', '2024-12-08 22:07:49'),
(15, 1, 'Anonym', 3, 'coba \\r\\nkatakan saja', '2024-12-08 22:08:02'),
(16, 1, 'Anonym', 1, 'aku\\r\\nkamu', '2024-12-08 22:10:49'),
(17, 1, 'Anonym', 3, 'aku\\r\\nsuka\\r\\nmie ayam', '2024-12-08 22:19:58'),
(18, 1, 'Anonym', 1, 'kamu\\r\\naku', '2024-12-08 22:21:31'),
(19, 1, 'Anonym', 1, 'kok\\r\\nmasih\\r\\nada', '2024-12-08 22:25:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `santri`
--

CREATE TABLE `santri` (
  `id` int(11) NOT NULL,
  `nama_santri` varchar(100) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `id_unit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `santri`
--

INSERT INTO `santri` (`id`, `nama_santri`, `id_kelas`, `id_unit`) VALUES
(1, 'Santri Dummy', 1, NULL),
(5, 'habibi', 13, 3),
(6, 'Haufan', 2, 1),
(7, 'Alsaki Arsenio', 1, 1),
(8, 'Ashfa Kendhatu Joana', 1, 1),
(9, 'Haidar Abimana Arrozaq', 1, 1),
(10, 'Muhammad Fatih Wibisono', 1, 1),
(11, 'Nabila Zafira Mecca', 1, 1),
(12, 'Hanin Humaira', 2, 1),
(13, 'Aysila Husna Sharletta', 2, 1),
(14, 'Gemi Zafina Azzahra', 2, 1),
(15, 'Octend Quthb Benedi', 2, 1),
(16, 'Arquinno R. Nadewa', 2, 1),
(17, 'Alexandra Kinanti Joana', 3, 1),
(18, 'Eleno Muza Awwab', 3, 1),
(19, 'Muhammad Ashraf Hakim', 3, 1),
(20, 'Yasmine Ainun Tawakal', 3, 1),
(21, 'Sofia Larasati', 3, 1),
(22, 'Agsesia Mahreen E.', 4, 1),
(23, 'Arka Al Kahfi', 4, 1),
(24, 'Banyu Narendra jati', 4, 1),
(25, 'Cahya Aruna Pungkasaning K.', 4, 1),
(26, 'Fathiya Almahyra Khanza', 4, 1),
(27, 'A. Azzam Khoirul Hafizh', 5, 1),
(28, 'Aishwarya Janyagita', 5, 1),
(29, 'Albirru Keenan P.', 5, 1),
(30, 'Almaira Azalia Qirani', 5, 1),
(31, 'Arsyila Qudsia', 5, 1),
(32, 'Abimana Fender Abrar', 6, 1),
(33, 'Agan Satrianing Mahesa', 6, 1),
(34, 'Albar Arzaquna Wardhana', 6, 1),
(35, 'Almanara Aralin Zidni', 6, 1),
(36, 'Ardianing Keyna Nur Aisyah', 6, 1),
(37, 'Ardianing Keyna Nur Aisyah', 6, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `statistik`
--

CREATE TABLE `statistik` (
  `id` int(11) NOT NULL,
  `nama_statistik` varchar(50) NOT NULL,
  `nilai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `statistik`
--

INSERT INTO `statistik` (`id`, `nama_statistik`, `nilai`) VALUES
(1, 'guru_total', '12'),
(2, 'tahun_berdiri', '5'),
(3, 'santri_aktif', '150');

-- --------------------------------------------------------

--
-- Struktur dari tabel `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `nama_unit` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `unit`
--

INSERT INTO `unit` (`id`, `nama_unit`) VALUES
(1, 'TKA TPA'),
(2, 'TQA'),
(3, 'TQAL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `tanggal_dibuat`) VALUES
(1, 'admin', '$2y$10$unzzf9SEN5OfB9UyOVPDG.Tll3Yd7Ut1MOiFRgwGiLF/390P4NrW.', 'admin', '2024-12-08 16:41:35'),
(2, 'user', '$2y$10$ZofXlK/905AOxhoVQLP9Qe4CbuOGxf9hikimIx2APY/J.7WtQCxT.', 'user', '2024-12-08 16:45:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `galeri_kategori`
--
ALTER TABLE `galeri_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `hari_libur`
--
ALTER TABLE `hari_libur`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal_kegiatan`
--
ALTER TABLE `jadwal_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tingkat` (`id_unit`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pendaftaran_santri`
--
ALTER TABLE `pendaftaran_santri`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_santri` (`id_santri`,`tanggal`);

--
-- Indeks untuk tabel `rating_testimoni`
--
ALTER TABLE `rating_testimoni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengguna_id` (`pengguna_id`);

--
-- Indeks untuk tabel `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `fk_unit` (`id_unit`);

--
-- Indeks untuk tabel `statistik`
--
ALTER TABLE `statistik`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `galeri_kategori`
--
ALTER TABLE `galeri_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `hari_libur`
--
ALTER TABLE `hari_libur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jadwal_kegiatan`
--
ALTER TABLE `jadwal_kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran_santri`
--
ALTER TABLE `pendaftaran_santri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=366;

--
-- AUTO_INCREMENT untuk tabel `rating_testimoni`
--
ALTER TABLE `rating_testimoni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `santri`
--
ALTER TABLE `santri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `statistik`
--
ALTER TABLE `statistik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id`);

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rating_testimoni`
--
ALTER TABLE `rating_testimoni`
  ADD CONSTRAINT `rating_testimoni_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `santri`
--
ALTER TABLE `santri`
  ADD CONSTRAINT `fk_unit` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id`),
  ADD CONSTRAINT `santri_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`);

--
-- Ketidakleluasaan untuk tabel `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
