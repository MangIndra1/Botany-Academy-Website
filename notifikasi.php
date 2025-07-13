<?php
include '_includes/db_connect.php';
include '_includes/header.php';

// Keamanan: Hanya pengguna yang sudah login yang bisa mengakses halaman ini
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fungsi untuk format waktu yang lebih lengkap
function time_ago($timestamp) {
    $time_difference = time() - strtotime($timestamp);
    if ($time_difference < 60) { return 'Baru saja'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'tahun',
                        30 * 24 * 60 * 60       =>  'bulan',
                        24 * 60 * 60            =>  'hari',
                        60 * 60                 =>  'jam',
                        60                      =>  'menit',
                        1                       =>  'detik'
    );
    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;
        if ($d >= 1) {
            $t = round($d);
            return $t . ' ' . $str . ' yang lalu';
        }
    }
}

// Ambil semua notifikasi untuk pengguna ini, diurutkan dari yang terbaru
$stmt = $conn->prepare("SELECT sender_name, sender_avatar, pesan, link, is_dibaca, created_at FROM notifikasi WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$notifications = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>

<div class="container my-5" style="max-width: 800px;">
    <h1 class="fw-bold mb-4">Notifikasi Saya</h1>

    <div class="notification-list">
        <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $notif): ?>
                <a href="<?php echo htmlspecialchars($notif['link']); ?>" class="notification-item d-flex p-3 border-bottom text-decoration-none">
                    <img src="assets/img/notif/<?php echo htmlspecialchars($notif['sender_avatar']); ?>" alt="Avatar" class="rounded-circle me-3" width="50" height="50">
                    <div class="flex-grow-1">
                        <p class="mb-1 text-dark">
                            <strong class="fw-bold"><?php echo htmlspecialchars($notif['sender_name']); ?></strong> 
                            <?php echo htmlspecialchars($notif['pesan']); ?>
                        </p>
                        <small class="text-muted"><?php echo time_ago($notif['created_at']); ?></small>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">Anda tidak memiliki notifikasi baru.</div>
        <?php endif; ?>
    </div>

    <?php if (!empty($notifications)): ?>
    <div class="text-center mt-4">
        <form action="_actions/notification_process.php" method="POST" style="display: inline;">
             <button type="submit" name="mark_all_read" class="btn btn-success">Tandai Semua Dibaca</button>
        </form>
    </div>
    <?php endif; ?>
</div>

<?php include '_includes/footer.php'; ?>