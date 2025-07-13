<?php
include '_includes/db_connect.php';
include '_includes/header.php';

// Keamanan: Hanya user yang sudah login yang bisa mengakses halaman ini
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$profile_errors = [];
$profile_success = '';
$password_errors = [];
$password_success = '';

// Cek apakah ada form yang di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // JIKA TOMBOL 'SIMPAN PROFIL' DITEKAN
    if (isset($_POST['update_profile'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);

        if (empty($username)) { $profile_errors[] = "Nama lengkap tidak boleh kosong."; }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $profile_errors[] = "Format email tidak valid."; }
        
        $stmt_check_email = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt_check_email->bind_param("si", $email, $user_id);
        $stmt_check_email->execute();
        if ($stmt_check_email->get_result()->num_rows > 0) {
            $profile_errors[] = "Email ini sudah digunakan oleh akun lain.";
        }
        $stmt_check_email->close();

        if (empty($profile_errors)) {
            $stmt_update = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            $stmt_update->bind_param("ssi", $username, $email, $user_id);
            if ($stmt_update->execute()) {
                $_SESSION['username'] = $username;
                $profile_success = "Profil berhasil diperbarui!";
            } else {
                $profile_errors[] = "Gagal memperbarui profil.";
            }
            $stmt_update->close();
        }
    }

    // JIKA TOMBOL 'UBAH PASSWORD' DITEKAN
    if (isset($_POST['update_password'])) {
        $old_password = $_POST['password_lama'];
        $new_password = $_POST['password_baru'];
        $confirm_new_password = $_POST['konfirmasi_password_baru'];

        if (empty($old_password) || empty($new_password) || empty($confirm_new_password)) {
            $password_errors[] = "Semua kolom password harus diisi.";
        } elseif ($new_password != $confirm_new_password) {
            $password_errors[] = "Password baru dan konfirmasi tidak cocok.";
        } elseif (strlen($new_password) < 6) {
            $password_errors[] = "Password baru minimal harus 6 karakter.";
        } else {
            // Ambil hash password saat ini dari DB
            $stmt_pass = $conn->prepare("SELECT password FROM users WHERE id = ?");
            $stmt_pass->bind_param("i", $user_id);
            $stmt_pass->execute();
            $user_data = $stmt_pass->get_result()->fetch_assoc();
            $stmt_pass->close();
            
            // Verifikasi password lama
            if (password_verify($old_password, $user_data['password'])) {
                // Jika password lama benar, hash password baru dan update ke DB
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt_update_pass = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt_update_pass->bind_param("si", $new_hashed_password, $user_id);
                if ($stmt_update_pass->execute()) {
                    $password_success = "Password berhasil diubah!";
                } else {
                    $password_errors[] = "Gagal mengubah password.";
                }
                $stmt_update_pass->close();
            } else {
                $password_errors[] = "Password lama Anda salah.";
            }
        }
    }
}

// Ambil data pengguna terbaru untuk ditampilkan di form profil
$stmt_user = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user = $stmt_user->get_result()->fetch_assoc();
$stmt_user->close();
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold mb-4">Pengaturan Akun</h1>

            <div class="card shadow-sm">
                <div class="card-header"><h5 class="mb-0">Informasi Profil</h5></div>
                <div class="card-body">
                    <?php if (!empty($profile_success)): ?><div class="alert alert-success"><?php echo $profile_success; ?></div><?php endif; ?>
                    <?php if (!empty($profile_errors)): ?><div class="alert alert-danger"><?php foreach ($profile_errors as $error) { echo "<p class='mb-0'>$error</p>"; } ?></div><?php endif; ?>
                    <form action="pengaturan.php" method="POST">
                        <div class="mb-3"><label for="username" class="form-label">Nama Lengkap</label><input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required></div>
                        <div class="mb-3"><label for="email" class="form-label">Alamat Email</label><input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required></div>
                        <button type="submit" name="update_profile" class="btn btn-success">Simpan Profil</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header"><h5 class="mb-0">Ubah Password</h5></div>
                <div class="card-body">
                    <?php if (!empty($password_success)): ?><div class="alert alert-success"><?php echo $password_success; ?></div><?php endif; ?>
                    <?php if (!empty($password_errors)): ?><div class="alert alert-danger"><?php foreach ($password_errors as $error) { echo "<p class='mb-0'>$error</p>"; } ?></div><?php endif; ?>
                    <form action="pengaturan.php" method="POST">
                        <div class="mb-3"><label for="password_lama" class="form-label">Password Lama</label><input type="password" class="form-control" id="password_lama" name="password_lama" required></div>
                        <div class="mb-3"><label for="password_baru" class="form-label">Password Baru</label><input type="password" class="form-control" id="password_baru" name="password_baru" required></div>
                        <div class="mb-3"><label for="konfirmasi_password_baru" class="form-label">Konfirmasi Password Baru</label><input type="password" class="form-control" id="konfirmasi_password_baru" name="konfirmasi_password_baru" required></div>
                        <button type="submit" name="update_password" class="btn btn-success">Ubah Password</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include '_includes/footer.php'; ?>