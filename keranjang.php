<?php
// File: keranjang.php

$body_class = 'bg-white';
include '_includes/db_connect.php';
include '_includes/header.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?redirect_url=keranjang.php');
    exit();
}

// Inisialisasi
$cart_items = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];
$courses_in_cart = [];
$total_price = 0;

if (!empty($cart_items)) {
    $placeholders = implode(',', array_fill(0, count($cart_items), '?'));
    $types = str_repeat('i', count($cart_items));

    // SARAN 1: Optimasi query, hanya ambil kolom yang diperlukan
    $sql = "SELECT id, title, author, price, thumbnail_image FROM courses WHERE id IN ($placeholders)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$cart_items);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $courses_in_cart[] = $row;
        $total_price += $row['price'];
    }
    $stmt->close();
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <h2 class="fw-bold">Keranjang Belanja</h2>
            <p class="text-muted"><?php echo count($courses_in_cart); ?> Kelas dalam Keranjang</p>
            <hr>
            
            <?php if (!empty($courses_in_cart)): ?>
                <?php foreach ($courses_in_cart as $item): ?>
                    <div class="row mb-3 align-items-center">
                        <div class="col-3 col-md-2">
                            <img src="assets/img/thumbnails/<?php echo htmlspecialchars($item['thumbnail_image']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        </div>
                        <div class="col-9 col-md-7">
                            <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($item['title']); ?></h5>
                            <p class="small text-muted mb-1">Oleh <?php echo htmlspecialchars($item['author']); ?></p>
                            <a href="_actions/cart_process.php?action=remove&id=<?php echo $item['id']; ?>" class="small text-danger text-decoration-none">Hapus</a>
                        </div>
                        <div class="col-12 col-md-3 text-md-end mt-2 mt-md-0">
                            <p class="fw-bold mb-1"><?php echo 'Rp ' . number_format($item['price'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    Keranjang belanja Anda kosong. <a href="courses.php">Mulai jelajahi kelas!</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Total:</h4>
                    <h2 class="fw-bold my-3"><?php echo 'Rp ' . number_format($total_price, 0, ',', '.'); ?></h2>
                    <div class="d-grid">
                        <a href="checkout.php" class="btn btn-success btn-lg <?php echo empty($courses_in_cart) ? 'disabled' : ''; ?>">
                            Lanjutkan ke Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '_includes/footer.php'; ?>