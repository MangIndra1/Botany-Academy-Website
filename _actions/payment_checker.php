<?php
// File: _actions/payment_checker.php (Versi Final)

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../_includes/db_connect.php';

// Keamanan: pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Keamanan: pastikan ada detail pembayaran di sesi
if (!isset($_SESSION['payment_details']['enroll_ids']) || !is_array($_SESSION['payment_details']['enroll_ids'])) {
    header('Location: ../dashboard.php');
    exit();
}

$enroll_ids = $_SESSION['payment_details']['enroll_ids'];
$user_id = $_SESSION['user_id'];

if (empty($enroll_ids)) {
    header('Location: ../dashboard.php');
    exit();
}

// Gunakan perulangan untuk mengupdate status setiap pendaftaran
foreach ($enroll_ids as $enroll_id) {
    $stmt = $conn->prepare("UPDATE pendaftar SET status_pembayaran = 'completed' WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $enroll_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Siapkan pesan notifikasi sukses
$_SESSION['flash_message'] = "Pembayaran berhasil! Selamat belajar.";

// PENTING: Hapus sesi pembayaran SETELAH semua proses selesai
unset($_SESSION['payment_details']);

// Arahkan pengguna ke halaman "Kelas Saya"
header('Location: ../dashboard.php');
exit();
?>