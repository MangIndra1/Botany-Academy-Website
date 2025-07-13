<?php
// File: _actions/cart_process.php

// Selalu mulai sesi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Pastikan ada action dan id yang dikirim
if (isset($_GET['action']) && isset($_GET['id'])) {
    
    $action = $_GET['action'];
    // SARAN #2: Sanitasi ID dengan mengubahnya menjadi integer
    $id = (int)$_GET['id'];

    if ($action == 'add' && $id > 0) {
        // Tambahkan item ke keranjang jika belum ada
        if (!in_array($id, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $id;
        }
    } 
    elseif ($action == 'remove' && $id > 0) {
        $key = array_search($id, $_SESSION['cart']);
        
        if ($key !== false) {
            unset($_SESSION['cart'][$key]);
            
            // SARAN #3: Rapikan kembali indeks array setelah item dihapus
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
}

// SARAN #1: Logika untuk Redirect Dinamis
if (isset($_GET['redirect']) && $_GET['redirect'] == 'checkout') {
    // Jika ada parameter redirect=checkout, arahkan ke halaman checkout
    header('Location: ../checkout.php');
    exit();
}

// Default, jika tidak ada arahan khusus, selalu kembali ke halaman keranjang
header('Location: ../keranjang.php');
exit();
?>