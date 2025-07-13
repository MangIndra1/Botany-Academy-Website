<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../_includes/db_connect.php';

// Keamanan: Cek login dan metode POST
if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: ../login.php');
    exit();
}

// Keamanan: Pastikan semua data yang dibutuhkan ada
if (!isset($_POST['enrollment_id']) || !isset($_POST['material_id']) || !isset($_POST['course_id'])) {
    header('Location: ../dashboard.php');
    exit();
}

// Ambil data
$enrollment_id = (int)$_POST['enrollment_id'];
$material_id = (int)$_POST['material_id'];
$course_id = (int)$_POST['course_id']; // Untuk redirect kembali

// Cek dulu agar tidak ada progres duplikat
$check_stmt = $conn->prepare("SELECT id FROM progress WHERE enrollment_id = ? AND material_id = ?");
$check_stmt->bind_param("ii", $enrollment_id, $material_id);
$check_stmt->execute();
$result = $check_stmt->get_result();
$check_stmt->close();

// Jika belum ada data progres untuk materi ini, baru masukkan
if ($result->num_rows === 0) {
    $insert_stmt = $conn->prepare("INSERT INTO progress (enrollment_id, material_id) VALUES (?, ?)");
    $insert_stmt->bind_param("ii", $enrollment_id, $material_id);
    $insert_stmt->execute();
    $insert_stmt->close();
}

// Redirect kembali ke halaman belajar, ke materi yang sama
header('Location: ../learning.php?course_id=' . $course_id . '&materi_id=' . $material_id);
exit();
?>