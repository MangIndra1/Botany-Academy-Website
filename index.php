<?php
include '_includes/header.php';
// Memuat koneksi database
include '_includes/db_connect.php';
?>

<!-- Hero Section -->
<section class="py-5 hero-section section-bg-accent">
    <div class="container d-flex flex-column flex-lg-row align-items-center">
        <div class="col-lg-6 text-center text-lg-start">
            <h1 class="display-5 fw-bold mb-3">Belajar Berkebun Dari Ahlinya</h1>
            <p class="mb-4">
                Akses kelas berkebun online dari mana saja dan kapan saja di Botany
            </p>
            <a href="courses.php" class="btn btn-dark me-4">Jelajahi Kelas</a>
            <a href="#about-us" class="btn-link-custom">Tentang Kami</a>
        </div>
        <div class="col-lg-6 text-center mt-4 mt-lg-0">
            <img src="assets/img/Home1.png" alt="Ilustrasi hero Botany" width="70%" />
        </div>
    </div>
</section>

<!-- About Botany Section -->
<section id="about-us" class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0 text-center text-lg-start">
                <img
                    src="assets/img/Asset2.png"
                    class="img-fluid rounded-4" 
                    alt="Seorang perempuan belajar berkebun secara online dari laptop"
                    width="75%"
                />
            </div>
            <div class="col-lg-6 text-center text-lg-start">
                <h2 class="fw-bold mb-3">Apa itu Botany Academy?</h2>
                <p class="mb-4">
                    <strong>Botany Academy adalah platform e-learning yang
                    dirancang untuk siapa saja yang ingin belajar
                    berkebun secara praktis dan menyenangkan.</strong> 
                </p>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex">
                            <div class="me-2 text-success">
                                <img src="assets/img/check-circle.png" alt="check" width="25" />
                            </div>
                            <div>
                                <strong>Belajar Fleksibel</strong><br />
                                Akses materi belajar kapan saja sesuai jadwalmu.
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex">
                            <div class="me-2 text-success">
                                <img src="assets/img/check-circle.png" alt="check" width="25" />
                            </div>
                            <div>
                                <strong>Mentor Ahli</strong><br />
                                Dipandu oleh para praktisi dan ahli berkebun yang berpengalaman.
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex">
                            <div class="me-2 text-success">
                                <img src="assets/img/check-circle.png" alt="check" width="25" />
                            </div>
                            <div>
                                <strong>Sertifikat Digital</strong><br />
                                Setiap penyelesaian kelas akan memberimu sertifikat digital resmi.
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex">
                            <div class="me-2 text-success">
                                <img src="assets/img/check-circle.png" alt="check" width="25" />
                            </div>
                            <div>
                                <strong>Komunitas Aktif</strong><br />
                                Bergabunglah dengan komunitas pegiat tanaman dari seluruh Indonesia.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Benefit -->
<section class="py-5 section-bg-accent">
    <div class="container">
        <h2 class="fw-bold mb-4 text-center">
            Dapatkan Berbagai Benefit
        </h2>

        <div class="row text-center mb-5">
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <div class="mb-2">
                        <img src="assets/img/benefit1.png" alt="Ikon Akses Kelas" width="35" />
                    </div>
                    <h5 class="fw-bold">Akses Kelas Botany</h5>
                    <p class="mb-0 small text-muted">
                        Pelajari materi kapan pun tanpa batas waktu. Kelas yang kamu beli akan selalu tersedia.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <div class="mb-2">
                        <img src="assets/img/benefit2.png" alt="Ikon Mentor Berpengalaman" width="35" />
                    </div>
                    <h5 class="fw-bold">Mentor Berpengalaman</h5>
                    <p class="mb-0 small text-muted">
                        Konsultasi dengan ahli disini dan ceritakan masalahmu seputar tanaman atau berkebun.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <div class="mb-2">
                        <img src="assets/img/benefit3.png" alt="Ikon Forum Diskusi" width="35" />
                    </div>
                    <h5 class="fw-bold">Forum Diskusi Interaktif</h5>
                    <p class="mb-0 small text-muted">
                        Terhubung dengan sesama pengguna untuk bertanya, berbagi pengalaman, atau berdiskusi tentang tanaman favoritmu.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <img src="assets/img/woman.png" class="galeri-img-kiri" alt="Perempuan sedang merawat tanaman sukulen" />
            </div>
            <div class="col-md-6">
                <div class="row g-4">
                    <div class="col-6">
                        <img src="assets/img/woman1.png" class="galeri-img-kanan-atas" alt="Perempuan menggunakan ponsel di antara tanaman" />
                    </div>
                    <div class="col-6">
                        <img src="assets/img/laptop.png" class="galeri-img-kanan-atas" alt="Belajar berkebun melalui laptop" />
                    </div>
                    <div class="col-12">
                        <img src="assets/img/tim.png" class="galeri-img-kanan-bawah" alt="Beberapa tangan sedang merawat tanaman bersama" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4 text-center">Kelas Unggulan Kami</h2>
        <div class="row g-4 justify-content-center">
            <?php
            // 1. Query untuk mengambil 3 kelas dengan rating tertinggi
            $sql = "SELECT id, title, short_description, price, thumbnail_image FROM courses ORDER BY rating DESC LIMIT 3";
            $result = mysqli_query($conn, $sql);

            // 2. Periksa dan tampilkan hasilnya
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="card shadow-sm w-100">
                            <a href="course_detail.php?id=<?php echo $row['id']; ?>">
                                <img src="assets/img/thumbnails/<?php echo htmlspecialchars($row['thumbnail_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>" style="height: 200px; object-fit: cover;">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">
                                    <a href="course_detail.php?id=<?php echo $row['id']; ?>" class="text-dark text-decoration-none">
                                        <?php echo htmlspecialchars($row['title']); ?>
                                    </a>
                                </h5>
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
                } // Akhir dari while loop
            } else {
                echo "<p class='text-center'>Belum ada kelas unggulan yang tersedia.</p>";
            }
            ?>
        </div>
        <div class="text-center mt-5">
            <a href="courses.php" class="btn btn-success">Lihat Semua Kelas</a>
        </div>
    </div>
</section>

<!-- Section CTA -->
<section class="bg-dark text-white rounded-4 my-5 mx-3 mx-md-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
                <h2 class="fw-bold display-6 mb-0">
                    Mulai Belajar Sekarang
                </h2>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="contact.php" class="btn btn-light me-3 mb-2 mb-md-0">Hubungi Kami</a>
                <a href="courses.php" class="btn btn-success me-3 mb-2 mb-md-0">Jelajahi Kelas</a>
            </div>
        </div>
    </div>
</section>


<?php
// Memuat footer
include '_includes/footer.php';
?>