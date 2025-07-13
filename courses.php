<?php
include '_includes/db_connect.php';
include '_includes/header.php';
?>

<section class="py-5 section-bg-accent">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center mb-4 mb-md-0">
                <img src="assets/img/cewekcourse1.png" alt="Mahasiswa Botany Academy" class="img-fluid" style="max-width: 350px;" />
            </div>
            <div class="col-md-6">
                <h1 class="fw-bold mb-3">Course yang Memberi Hasil Fokus Praktik & Perawatan.</h1>
                <p class="text-muted mb-4">
                    Full Online dan Dipandu oleh Praktisi Senior. Praktikal, lebih dari sekadar Webinar. Fokus Bantu Kembangkan Skill Anda.
                </p>
                <div class="d-flex align-items-center mt-3">
                    <div class="me-3">
                        <img src="assets/img/oranglulus/Frame 1000003708.png" alt="Alumni" class="img-fluid" style="height: 40px" />
                    </div>
                    <span class="text-muted">10.000 Orang Telah Lulus</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <h2 class="fw-bold mb-4 text-center">Jelajahi Semua Kelas Kami</h2>
        <div class="row g-4">
            <?php
            // PERBAIKAN 2: Menggunakan Prepared Statements & PERBAIKAN 3: Menambahkan 'author'
            $sql = "SELECT id, title, author, short_description, price, thumbnail_image FROM courses ORDER BY id ASC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="card shadow-sm w-100 course-card-dashboard">
                            <a href="course_detail.php?id=<?php echo $row['id']; ?>">
                                <img src="assets/img/thumbnails/<?php echo htmlspecialchars($row['thumbnail_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">
                                    <a href="course_detail.php?id=<?php echo $row['id']; ?>" class="text-dark text-decoration-none">
                                        <?php echo htmlspecialchars($row['title']); ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted small mb-2">Oleh <?php echo htmlspecialchars($row['author']); ?></p>
                                <p class="card-text flex-grow-1 small text-muted"><?php echo htmlspecialchars($row['short_description']); ?></p>
                                <div class="mt-auto">
                                    <p class="card-text fw-bold fs-5">
                                        <?php echo ($row['price'] == 0) ? '<span class="text-success">Gratis</span>' : 'Rp ' . number_format($row['price'], 0, ',', '.'); ?>
                                    </p>
                                    <a href="course_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-dark w-100 mt-2">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                } // Akhir while
            } else {
                echo "<div class='col-12'><p class='text-center'>Saat ini belum ada kelas yang tersedia.</p></div>";
            }
            $stmt->close(); // Tutup statement
            ?>
        </div>
    </div>
</section>

<section class="py-5" id="testimoni">
    </section>

<?php
// Memuat footer
include '_includes/footer.php';
?>