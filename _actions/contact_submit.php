<?php
// File: _actions/contact_submit.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 1. Pastikan diakses via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ambil dan bersihkan data dari form (CARA BARU & BENAR)
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Sanitasi data untuk keamanan
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    // Validasi email akan kita lakukan di bawah, jadi tidak perlu sanitasi khusus

    // 3. Validasi sederhana
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // 4. Siapkan format pesan untuk disimpan
        $timestamp = date("Y-m-d H:i:s");
        $log_entry = "------------------------------\n";
        $log_entry .= "Tanggal: " . $timestamp . "\n";
        $log_entry .= "Nama: " . $name . "\n";
        $log_entry .= "Email: " . $email . "\n";
        $log_entry .= "Pesan: \n" . $message . "\n";
        $log_entry .= "------------------------------\n\n";

        // 5. Simpan pesan ke file log. FILE_APPEND memastikan tidak menimpa pesan lama.
        $log_file_path = '../_messages/contact_log.txt';
        file_put_contents($log_file_path, $log_entry, FILE_APPEND | LOCK_EX);

        // 6. Siapkan pesan sukses (flash message)
        $_SESSION['flash_message'] = "Terima kasih! Pesan Anda telah kami terima.";

    } else {
        // Jika validasi gagal
        $_SESSION['flash_message'] = "Gagal mengirim pesan. Mohon isi semua kolom dengan benar.";
    }
}

// 7. Arahkan kembali ke halaman kontak
header('Location: ../contact.php');
exit();
?>