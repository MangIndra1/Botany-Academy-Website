<?php
// File: learning.php (Versi Final Gabungan)

include '_includes/db_connect.php';
include '_includes/header.php';

// --- (Semua logika PHP untuk keamanan dan pengambilan data tetap sama) ---
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }
if (!isset($_GET['course_id']) || !is_numeric($_GET['course_id'])) { header('Location: dashboard.php'); exit(); }
$user_id = $_SESSION['user_id'];
$course_id = (int)$_GET['course_id'];
$stmt_check = $conn->prepare("SELECT id FROM pendaftar WHERE user_id = ? AND course_id = ? AND status_pembayaran = 'completed'");
$stmt_check->bind_param("ii", $user_id, $course_id);
$stmt_check->execute();
$enrollment_result = $stmt_check->get_result();
if ($enrollment_result->num_rows === 0) {
    $_SESSION['flash_message'] = "Anda tidak memiliki akses ke kelas ini.";
    header('Location: dashboard.php');
    exit();
}
$enrollment = $enrollment_result->fetch_assoc();
$enrollment_id = $enrollment['id'];
$stmt_check->close();
$course_stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
$course_stmt->bind_param("i", $course_id);
$course_stmt->execute();
$course = $course_stmt->get_result()->fetch_assoc();
$course_stmt->close();
$materi_stmt = $conn->prepare("SELECT * FROM materi WHERE course_id = ? ORDER BY order_number ASC");
$materi_stmt->bind_param("i", $course_id);
$materi_stmt->execute();
$all_materials = $materi_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$materi_stmt->close();
$progress_stmt = $conn->prepare("SELECT material_id FROM progress WHERE enrollment_id = ?");
$progress_stmt->bind_param("i", $enrollment_id);
$progress_stmt->execute();
$progress_result = $progress_stmt->get_result();
$completed_materials_ids = [];
while ($row = $progress_result->fetch_assoc()) {
    $completed_materials_ids[] = $row['material_id'];
}
$progress_stmt->close();
$active_material_id = isset($_GET['materi_id']) ? (int)$_GET['materi_id'] : ($all_materials[0]['id'] ?? 0);
?>

<div class="learning-subheader">
    <div class="container-fluid px-4 d-flex justify-content-between align-items-center">
        <a href="dashboard.php" class="btn btn-dark btn-sm d-none d-lg-block">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <span class="text-white fw-bold"><?php echo htmlspecialchars($course['title']); ?></span>
        <button class="btn btn-dark btn-sm d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMateri" aria-controls="sidebarMateri">
            <i class="bi bi-list-ul"></i> Materi
        </button>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <main class="col-lg-9 py-4 px-4">
            <?php
            // Logika untuk menampilkan konten aktif
            $active_material = null;
            if (!empty($all_materials)) {
                foreach ($all_materials as $materi_item) {
                    if ($materi_item['id'] == $active_material_id) {
                        $active_material = $materi_item;
                        break;
                    }
                }
            }
            if ($active_material) :
            ?>
                <div class="learning-content mb-4">
                    <?php if ($active_material['type'] == 'video'): ?>
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($active_material['content']); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    <?php else: ?>
                        <div class="article-content p-4 border rounded bg-white">
                            <h3 class="fw-bold mb-3"><?php echo htmlspecialchars($active_material['title']); ?></h3>
                            <?php echo nl2br(htmlspecialchars($active_material['content'])); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="alert alert-info">Selamat datang! Silakan pilih materi dari daftar di samping untuk memulai pembelajaran.</div>
            <?php endif; ?>
        </main>

        <aside class="col-lg-3 border-start p-0 learning-sidebar offcanvas-lg offcanvas-end" tabindex="-1" id="sidebarMateri">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title">Konten Kursus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMateri" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                <div class="list-group list-group-flush">
                    <?php foreach ($all_materials as $materi) : ?>
                        <?php 
                            $is_completed = in_array($materi['id'], $completed_materials_ids);
                            $is_active = ($materi['id'] == $active_material_id);
                        ?>
                        <a href="learning.php?course_id=<?php echo $course_id; ?>&materi_id=<?php echo $materi['id']; ?>" class="list-group-item list-group-item-action <?php echo $is_active ? 'active' : ''; ?>">
                            <div class="d-flex w-100 justify-content-between">
                                <p class="mb-1 fw-bold small">
                                    <i class="bi <?php echo $is_completed ? 'bi-check-circle-fill text-success' : 'bi-play-circle'; ?> me-2"></i>
                                    <?php echo htmlspecialchars($materi['title']); ?>
                                </p>
                                <small class="text-muted"><?php echo $materi['duration_minutes']; ?>m</small>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php include '_includes/footer.php'; ?>