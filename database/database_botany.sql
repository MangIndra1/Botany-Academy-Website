-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jul 2025 pada 15.03
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
-- Database: `database_botany`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `details` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `author` varchar(100) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT 0.0,
  `participants` int(11) DEFAULT 0,
  `thumbnail_image` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `courses`
--

INSERT INTO `courses` (`id`, `title`, `short_description`, `details`, `price`, `author`, `rating`, `participants`, `thumbnail_image`) VALUES
(1, 'Hidroponik untuk Pemula', 'Belajar dasar-dasar menanam tanpa menggunakan tanah. Cocok untuk Anda yang ingin memulai hobi berkebun modern di rumah.', 'Dalam kelas ini, Anda akan dibimbing dari nol untuk membangun sistem hidroponik fungsional di rumah. Materi mencakup pengenalan berbagai sistem, cara meracik nutrisi, teknik penyemaian, hingga tips perawatan harian.', 149000.00, 'Galih Tambunan', 4.5, 6071, 'hidroponik_pemula.svg'),
(2, 'Seni Merawat Bonsai', 'Kuasai seni kuno dalam membentuk dan merawat bonsai. Pelajari teknik-teknik penting seperti pruning, wiring, dan pemupukan.', 'Bonsai adalah perpaduan antara seni dan hortikultura. Kelas ini akan membawa Anda menyelami dunia bonsai, mulai dari filosofi di baliknya, memilih bakalan prospektif, teknik pengawatan, hingga metode pemupukan dan pemangkasan.', 175000.00, 'Siti Lestari', 4.7, 3210, 'merawat_bonsai.svg'),
(3, 'Berkebun di Lahan Sempit', 'Maksimalkan ruang terbatas Anda menjadi oase hijau yang produktif dengan taman vertikal dan kebun pot.', 'Tidak punya halaman luas bukan berarti tidak bisa berkebun. Kelas ini didedikasikan untuk Anda yang tinggal di lingkungan urban. Pelajari cara cerdas memanfaatkan ruang vertikal, trik memilih pot dan media tanam yang tepat, serta daftar tanaman yang cocok.', 0.00, 'Budi Sanjaya', 4.2, 8954, 'lahan_sempit.svg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('video','article') NOT NULL,
  `content` text NOT NULL,
  `order_number` int(11) NOT NULL,
  `duration_minutes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`id`, `course_id`, `title`, `type`, `content`, `order_number`, `duration_minutes`) VALUES
(1, 1, 'Pengenalan Hidroponik', 'video', 'wBcnUUkdavE', 1, 10),
(2, 1, 'Memilih Sistem Hidroponik', 'video', 'KlkfDH7MOPk', 2, 12),
(3, 1, 'Meracik Nutrisi AB Mix', 'video', 'AKLEqCbvQ04', 3, 13),
(4, 1, 'Langkah-langkah Penyemaian', 'video', 'HjOwOpKufG0', 4, 10),
(5, 2, 'Memilih Bakalan Bonsai', 'video', 'BO8yuSTc3fo', 1, 15),
(6, 2, 'Teknik Wiring (Pengawatan) Dasar', 'video', 'X3SP1Fub3bw', 2, 10),
(7, 2, 'Prinsip Dasar Pemupukan', 'video', 'NlS_dTDsHHQ', 3, 10),
(8, 2, 'Pruning (Pemangkasan) untuk Estetika', 'video', '8Du4IxzJgaA', 4, 15),
(9, 3, 'Konsep Taman Vertikal', 'video', 'L14woJZEJnk', 1, 10),
(10, 3, 'Membuat Instalasi Taman Vertikal', 'video', 'eeEKQLEpZfA', 2, 12),
(11, 3, 'Memilih Tanaman untuk Pot', 'video', 'ZW6HUQRhnsg', 3, 8),
(12, 3, 'Tips Drainase dan Media Tanam', 'video', 'dERFIWLU7fo', 4, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender_name` varchar(100) NOT NULL,
  `sender_avatar` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_dibaca` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `sender_name`, `sender_avatar`, `pesan`, `link`, `is_dibaca`, `created_at`) VALUES
(1, 3, 'Botany Academy', 'notif1.svg', 'Selamat! 🎉 Anda telah menyelesaikan kelas Hidroponik untuk Pemula. Lihat sertifikat Anda di dashboard!', 'dashboard.php', 1, '2025-07-10 11:53:29'),
(2, 3, 'Galih Tambunan', 'notif2.svg', 'Kelas baru telah ditambahkan: Seni Merawat Bonsai. Yuk, daftar sekarang!', 'course_detail.php?id=2', 1, '2025-07-10 11:53:29'),
(3, 5, 'Dinda Suminten', 'notif3.svg', 'Jangan lupa lanjutkan kelasmu! Terakhir Anda belajar Teknik Wiring (Pengawatan) Dasar.', 'learning.php?course_id=2', 0, '2025-07-10 11:53:29'),
(4, 5, 'Botany Academy', 'notif4.svg', 'Pembayaran untuk kelas \'Berkebun di Lahan Sempit\' telah kami terima. Selamat belajar!', 'dashboard.php', 0, '2025-07-10 11:53:29'),
(5, 6, 'Botany Academy', 'notif1.svg', 'Penawaran Spesial! Dapatkan diskon 30% untuk kelas Hidroponik untuk Pemula. Penawaran terbatas!', 'course_detail.php?id=1', 0, '2025-07-10 11:53:29'),
(6, 6, 'Siti Lestari', 'notif2.svg', 'Materi baru telah ditambahkan di kelas \'Seni Merawat Bonsai\': Teknik Pruning Lanjutan.', 'learning.php?course_id=2', 0, '2025-07-10 11:53:29'),
(7, 7, 'Botany Academy', 'notif1.svg', 'Selamat datang di Botany, I Komang Galih Agustan! Jelajahi kelas-kelas menarik kami untuk memulai.', 'courses.php', 0, '2025-07-10 12:35:54'),
(8, 7, 'Siti Lestari', 'notif2.svg', 'mengingatkan Anda untuk menyelesaikan pembayaran untuk kelas \'Seni Merawat Bonsai\' agar bisa segera diakses.', 'keranjang.php', 0, '2025-07-10 12:35:54'),
(9, 9, 'Botany Academy', 'notif1.svg', 'Terima kasih telah bergabung, Made Dinda! Kelas gratis \"Berkebun di Lahan Sempit\" sudah ditambahkan ke akunmu.', 'dashboard.php', 0, '2025-07-10 12:59:32'),
(10, 9, 'Galih Tambunan', 'notif2.svg', 'Hai! Ada materi baru di kelas Hidroponik tentang \"Mengatasi Hama Organik\". Yuk, cek sekarang!', 'learning.php?course_id=1', 0, '2025-07-10 12:59:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `status_pembayaran` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendaftar`
--

INSERT INTO `pendaftar` (`id`, `user_id`, `course_id`, `status_pembayaran`, `enrollment_date`) VALUES
(8, 3, 3, 'completed', '2025-06-23 09:43:01'),
(9, 3, 2, 'completed', '2025-07-06 08:04:30'),
(10, 3, 1, 'completed', '2025-07-06 08:04:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `progress`
--

CREATE TABLE `progress` (
  `id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(3, 'Komang Indra Pradnya', 'indrapradnya2005@gmail.com', '$2y$10$Rh3Gd9HZIJxcvRKSLKWUgOg8vEBmJeQrSQ2PmFa52KKtSf0hEfJVO', '2025-06-18 17:53:11'),
(5, 'I Gusti Agus Sakah Aditia', 'sakahagus@gmail.com', '$2y$10$7SGCeMMVGKPOq.xROxzc2eDP6B9SlE01lMkknYGwHdcVH2zCLPaOG', '2025-07-10 11:44:34'),
(6, 'I Kadek Dwika Pradnyana', 'toiletmaster11@gmail.com', '$2y$10$DeB4sA9Qpto7tCfkCwGV2OEA6X9so0p8eWzz8vxMG7fkIFrk2UOba', '2025-07-10 11:45:22'),
(7, 'I Komang Galih Agustan', 'jojojijijaja@gmail.com', '$2y$10$4b2XHZcg.KkS88OIDZdHquprjZsBFZHwmg.MTsCHw./1SAxfue7kC', '2025-07-10 12:28:35'),
(9, 'Made Dinda', 'mddinda456@gmail.com', '$2y$10$RMDuF7ou7vUAciR585yNO.Noj7MLO.9UarNf2rNErXxPNpQucJaW2', '2025-07-10 12:56:13');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indeks untuk tabel `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollment_id` (`enrollment_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD CONSTRAINT `pendaftar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftar_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
