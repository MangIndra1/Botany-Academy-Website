<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../_includes/db_connect.php';

// Keamanan: pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Pastikan form dikirim dengan tombol yang benar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mark_all_read'])) {
    
    $user_id = $_SESSION['user_id'];

    // Update semua notifikasi yang belum dibaca menjadi sudah dibaca
    $stmt = $conn->prepare("UPDATE notifikasi SET is_dibaca = 1 WHERE user_id = ? AND is_dibaca = 0");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

// Arahkan pengguna kembali ke halaman notifikasi
header('Location: ../notifikasi.php');
exit();
?>