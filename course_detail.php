<?php
include '_includes/db_connect.php';
include '_includes/header.php';

// Fungsi untuk membuat bintang rating dinamis
function generate_stars($rating) {
    $rating = round($rating * 2) / 2;
    $output = "";
    for ($i = 1; $i <= 5; $i++) {
        if ($rating >= $i) {
            $output .= '<i class="bi bi-star-fill text-warning"></i>'; // Bintang penuh
        } elseif ($rating > $i - 1 && $rating < $i) {
            $output .= '<i class="bi bi-star-half text-warning"></i>'; // Bintang setengah
        } else {
            $output .= '<i class="bi bi-star text-warning"></i>'; // Bintang kosong
        }
    }
    return $output;
}

// 1. Validasi ID (Sudah Benar)
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: courses.php');
    exit();
}
$course_id = (int)$_GET['id'];

// 2. Ambil detail kelas (Sudah Benar)
$stmt_course = $conn->prepare("SELECT * FROM courses WHERE id = ?");
$stmt_course->bind_param("i", $course_id);
$stmt_course->execute();
$result_course = $stmt_course->get_result();
if ($result_course->num_rows === 0) {
    header('Location: courses.php');
    exit();
}
$course = $result_course->fetch_assoc();
$stmt_course->close();

// 3. Ambil semua materi ke dalam array (Metode lebih efisien)
$stmt_materi = $conn->prepare("SELECT * FROM materi WHERE course_id = ? ORDER BY order_number ASC");
$stmt_materi->bind_param("i", $course_id);
$stmt_materi->execute();
$result_materi = $stmt_materi->get_result();
$materials_array = $result_materi->fetch_all(MYSQLI_ASSOC); // Ambil semua data sekaligus
$stmt_materi->close();

// --- Lakukan kalkulasi dari array ---
$total_materi = count($materials_array);
$total_menit = 0;
$total_artikel = 0;
$total_menit_video = 0;

foreach ($materials_array as $materi_calc) {
    $total_menit += $materi_calc['duration_minutes'];
    if ($materi_calc['type'] == 'article') {
        $total_artikel++;
    } else {
        $total_menit_video += $materi_calc['duration_minutes'];
    }
}
$jam_video = floor($total_menit_video / 60);
$menit_video = $total_menit_video % 60;

$jam_total = floor($total_menit / 60);
$menit_total = $total_menit % 60;
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="courses.php">Course</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($course['title']); ?></li>
                </ol>
            </nav>

            <h1 class="fw-bold display-5"><?php echo htmlspecialchars($course['title']); ?></h1>
            <p class="lead text-muted"><?php echo htmlspecialchars($course['short_description']); ?></p>
            <div class="d-flex align-items-center mb-3">
                <span class="fw-bold me-2"><?php echo htmlspecialchars($course['rating']); ?></span>
                <span class="me-2"><?php echo generate_stars($course['rating']); ?></span> <span class="text-muted">(<?php echo number_format($course['participants']); ?> peserta)</span>
            </div>
            <p class="small">Dibuat oleh <a href="#"><?php echo htmlspecialchars($course['author']); ?></a></p>
            
            <hr class="my-4">

            <div class="course-section">
                <h4 class="fw-bold">Deskripsi</h4>
                <p><?php echo nl2br(htmlspecialchars($course['details'])); ?></p>
            </div>

            <div class="course-section mt-5">
                <h4 class="fw-bold">Konten Kursus</h4>
                <p class="small text-muted"><?php echo $total_materi; ?> bagian • <?php echo "{$jam_total}j {$menit_total}m"; ?> total durasi</p>
                <ul class="list-group list-group-flush course-content-list">
                    <?php foreach ($materials_array as $materi) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi <?php echo ($materi['type'] == 'video') ? 'bi-play-circle' : 'bi-file-text'; ?> me-2"></i>
                                <?php echo htmlspecialchars($materi['title']); ?>
                            </div>
                            <span class="text-muted small"><?php echo ucfirst($materi['type']); ?> • <?php echo $materi['duration_minutes']; ?>m</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top course-sticky-card">
                <img src="assets/img/thumbnails/<?php echo htmlspecialchars($course['thumbnail_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($course['title']); ?>">
                <div class="card-body">
                    <h2 class="card-title fw-bold mb-3"><?php echo ($course['price'] == 0) ? 'Gratis' : 'Rp ' . number_format($course['price'], 0, ',', '.'); ?></h2>
                    <div class="d-grid gap-2">
                        <a href="_actions/cart_process.php?action=add&id=<?php echo $course['id']; ?>&redirect=keranjang" class="btn btn-outline-dark">Tambahkan ke keranjang</a>
                        <a href="_actions/cart_process.php?action=add&id=<?php echo $course['id']; ?>&redirect=checkout" class="btn btn-success">Daftar Sekarang</a>
                    </div>
                    <p class="text-center text-muted small my-3">Jaminan uang kembali 30 hari</p>
                    <h6 class="fw-bold">Kursus ini mencakup:</h6>
                    <ul class="list-unstyled course-includes-list small">
                        <li><i class="bi bi-camera-video"></i> <?php echo "{$jam_video}j {$menit_video}m"; ?> total durasi video</li>
                        <li><i class="bi bi-file-earmark-text"></i> <?php echo $total_artikel; ?> artikel</li>
                        <li><i class="bi bi-phone"></i> Akses di perangkat seluler dan desktop</li>
                        <li><i class="bi bi-infinity"></i> Akses penuh seumur hidup</li>
                        <li><i class="bi bi-patch-check"></i> Sertifikat penyelesaian</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '_includes/footer.php'; ?>