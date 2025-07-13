<?php
// File: dashboard.php

include '_includes/db_connect.php';
include '_includes/header.php';

// Keamanan: Hanya user yang sudah login yang bisa mengakses halaman ini
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// --- PENDEKATAN BARU YANG LEBIH EFISIEN ---

// 1. Ambil semua kelas yang diikuti pengguna
$sql_courses = "SELECT c.id, c.title, c.author, c.short_description, c.thumbnail_image 
                FROM courses c
                JOIN pendaftar p ON c.id = p.course_id
                WHERE p.user_id = ? AND p.status_pembayaran = 'completed'";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bind_param("i", $user_id);
$stmt_courses->execute();
$enrolled_courses = $stmt_courses->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt_courses->close();

// Siapkan array untuk menampung data progres dan total materi
$progress_data = [];
$total_materi_data = [];

if (!empty($enrolled_courses)) {
    // Dapatkan daftar course_id untuk digunakan di query selanjutnya
    $enrolled_course_ids = array_column($enrolled_courses, 'id');
    $placeholders = implode(',', array_fill(0, count($enrolled_course_ids), '?'));
    $types = str_repeat('i', count($enrolled_course_ids));
    
    // 2. Ambil JUMLAH MATERI SELESAI untuk SEMUA kelas dalam satu query
    $sql_progress = "SELECT p.course_id, COUNT(pr.id) as completed 
                     FROM progress pr
                     JOIN pendaftar p ON pr.enrollment_id = p.id
                     WHERE p.user_id = ? AND p.course_id IN ($placeholders)
                     GROUP BY p.course_id";
    $stmt_progress = $conn->prepare($sql_progress);
    $stmt_progress->bind_param("i" . $types, $user_id, ...$enrolled_course_ids);
    $stmt_progress->execute();
    $result_progress = $stmt_progress->get_result();
    while ($row = $result_progress->fetch_assoc()) {
        $progress_data[$row['course_id']] = $row['completed'];
    }
    $stmt_progress->close();

    // 3. Ambil JUMLAH TOTAL MATERI untuk SEMUA kelas dalam satu query
    $sql_total = "SELECT course_id, COUNT(id) as total FROM materi WHERE course_id IN ($placeholders) GROUP BY course_id";
    $stmt_total = $conn->prepare($sql_total);
    $stmt_total->bind_param($types, ...$enrolled_course_ids);
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    while ($row = $result_total->fetch_assoc()) {
        $total_materi_data[$row['course_id']] = $row['total'];
    }
    $stmt_total->close();
}
?>

<div class="container my-5">
    <h1 class="fw-bold mb-4">Pembelajaran saya</h1>

    <?php if (isset($_SESSION['flash_message'])) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['flash_message']; unset($_SESSION['flash_message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Semua kursus</a></li>
        <!-- <li class="nav-item"><a class="nav-link text-muted" href="#">Sertifikat</a></li> -->
    </ul>

    <div class="row mb-4">
        </div>

    <div class="row g-4">
        <?php if (!empty($enrolled_courses)) : ?>
            <?php foreach ($enrolled_courses as $course) : ?>
                <?php
                // Sekarang kalkulasi dilakukan dengan data dari array, bukan query baru
                $completed_materi = $progress_data[$course['id']] ?? 0;
                $total_materi = $total_materi_data[$course['id']] ?? 0;
                $progress_percentage = ($total_materi > 0) ? round(($completed_materi / $total_materi) * 100) : 0;
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card course-card-dashboard h-100 shadow-sm">
                        <a href="learning.php?course_id=<?php echo $course['id']; ?>">
                            <img src="assets/img/thumbnails/<?php echo htmlspecialchars($course['thumbnail_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($course['title']); ?>">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($course['title']); ?></h5>
                            <p class="card-text text-muted small">Oleh <?php echo htmlspecialchars($course['author']); ?></p>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $progress_percentage; ?>%;" aria-valuenow="<?php echo $progress_percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="small text-muted mt-1"><?php echo $progress_percentage; ?>% selesai</p>
                        </div>
                        <div class="card-footer bg-white border-0 p-3">
                            <a href="learning.php?course_id=<?php echo $course['id']; ?>" class="btn btn-success w-100">Mulai Belajar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12">
                <div class="alert alert-info">
                    Anda belum terdaftar di kelas manapun. <a href="courses.php">Jelajahi kelas sekarang!</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '_includes/footer.php'; ?>