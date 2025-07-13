<?php
// File: register.php

include '_includes/db_connect.php';

$errors = array();
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Mengambil data dari form. mysqli_real_escape_string tidak lagi diperlukan.
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi Input (logika ini sudah bagus)
    if (empty($username)) { array_push($errors, "Username tidak boleh kosong"); }
    if (empty($email)) { array_push($errors, "Email tidak boleh kosong"); }
    if (empty($password)) { array_push($errors, "Password tidak boleh kosong"); }
    if (strlen($password) < 6) { array_push($errors, "Password minimal harus 6 karakter"); }
    if ($password != $confirm_password) { array_push($errors, "Konfirmasi password tidak cocok"); }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { array_push($errors, "Format email tidak valid"); }

    // Jika validasi dasar lolos, cek duplikasi email dengan cara yang aman
    if (count($errors) == 0) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            array_push($errors, "Email sudah terdaftar, silakan gunakan email lain.");
        }
        $stmt->close();
    }

    // Jika tidak ada error sama sekali, daftarkan pengguna
    if (count($errors) == 0) {
        // Hash password (logika ini sudah benar)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Masukkan pengguna baru menggunakan prepared statement
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            // Jika berhasil, arahkan ke halaman login dengan pesan sukses
            header('Location: login.php?status=success');
            exit();
        } else {
            // Jika ada error dari database
            array_push($errors, "Registrasi gagal, silakan coba lagi.");
        }
        $stmt->close();
    }
}
?>

<?php include '_includes/header.php';?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Daftar Akun Baru</h3>

                    <?php if (count($errors) > 0) : ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error) : ?>
                                <p class="mb-0"><?php echo $error; ?></p>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>

                    <form method="post" action="register.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Daftar</button>
                        </div>
                    </form>

                    <p class="text-center mt-3 small">
                        Sudah punya akun? <a href="login.php">Login di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '_includes/footer.php';?>