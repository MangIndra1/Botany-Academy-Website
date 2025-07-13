<?php
// File: _includes/header.php (Versi Final)

// Memeriksa apakah sesi sudah aktif sebelum memulainya.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fungsi untuk membuat inisial nama
function getInitials($name) {
    $words = explode(" ", trim($name));
    $initials = "";
    if (isset($words[0]) && !empty($words[0])) {
        $initials .= strtoupper($words[0][0]);
    }
    if (isset($words[1]) && !empty($words[1])) {
        $initials .= strtoupper($words[1][0]);
    }
    return $initials ?: 'U'; // Default 'U' jika nama kosong
}

// Mendapatkan nama halaman saat ini untuk menu aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Botany Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body class="<?php echo isset($body_class) ? $body_class : ''; ?>">
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/LogoTeks.png" alt="Botany Academy Logo" width="120" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'courses.php') ? 'active' : ''; ?>" href="courses.php">Course</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="contact.php">Contact Us</a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <li class="nav-item d-lg-none"><hr></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="dashboard.php">Pembelajaran Saya</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="keranjang.php">Keranjang Saya</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="notifikasi.php">Notifikasi</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="pengaturan-akun.php">Pengaturan Akun</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                    <?php else : ?>
                        <li class="nav-item d-lg-none"><hr></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="login.php">Log In</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="register.php">Sign Up</a></li>
                    <?php endif; ?>
                </ul>

                <div class="d-none d-lg-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <a href="keranjang.php" class="text-dark me-3"><i class="bi bi-cart fs-5"></i></a>
                        <a href="notifikasi.php" class="text-dark me-4"><i class="bi bi-bell fs-5"></i></a>
                        <div class="dropdown">
                            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar"><?php echo getInitials($_SESSION['username']); ?></div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                                <li><div class="px-3 py-2"><strong class="d-block"><?php echo htmlspecialchars($_SESSION['username']); ?></strong></div></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="dashboard.php">Pembelajaran Saya</a></li>
                                <li><a class="dropdown-item" href="keranjang.php">Keranjang Saya</a></li>
                                <li><a class="dropdown-item" href="pengaturan-akun.php">Pengaturan Akun</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else : ?>
                        <a href="login.php" class="btn btn-green-outline me-2">Log In</a>
                        <a href="register.php" class="btn btn-green">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <main>