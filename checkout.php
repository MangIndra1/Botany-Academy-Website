<?php
// SARAN 1: Definisikan $body_class di paling atas
$body_class = 'bg-white';

include '_includes/db_connect.php';
include '_includes/header.php';

// Keamanan: Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?redirect_url=keranjang.php');
    exit();
}

// Ambil item dari sesi keranjang
$cart_items = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Jika keranjang kosong, arahkan kembali.
if (empty($cart_items)) {
    header('Location: keranjang.php');
    exit();
}

$courses_in_cart = [];
$total_price = 0;

// Logika pengambilan data dari DB (sudah bagus, tidak ada perubahan)
$placeholders = implode(',', array_fill(0, count($cart_items), '?'));
$types = str_repeat('i', count($cart_items));
$sql = "SELECT id, title, price FROM courses WHERE id IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$cart_items);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $courses_in_cart[] = $row;
    $total_price += $row['price'];
}
$stmt->close();
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-7">
            <h3>Checkout</h3>
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Pilih Metode Pembayaran :</h5>
                    <p class="card-text text-muted small">Silahkan pilih metode pembayaran untuk melakukan pendaftaran kelas Botany.</p>
                    
                    <form action="_actions/payment_process.php" method="POST">
                        <div class="list-group">
                            <label class="list-group-item list-group-item-action">
                                <input class="form-check-input me-2" type="radio" name="payment_method" value="BCA_VA" checked>
                                Transfer Virtual Account (BCA)
                            </label>
                            <label class="list-group-item list-group-item-action">
                                <input class="form-check-input me-2" type="radio" name="payment_method" value="GOPAY">
                                GoPay
                            </label>
                        </div>
                </div>
            </div>
            
            <h5 class="mt-4">Detail pesanan <span class="text-muted">(<?php echo count($courses_in_cart); ?> kursus)</span></h5>
            <?php foreach ($courses_in_cart as $item): ?>
            <div class="d-flex justify-content-between align-items-center p-3 border rounded mt-3">
                <span><?php echo htmlspecialchars($item['title']); ?></span>
                <span class="fw-bold"><?php echo 'Rp ' . number_format($item['price'], 0, ',', '.'); ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm position-sticky" style="top: 100px;">
                <div class="card-body">
                    <h4 class="card-title">Ringkasan pesanan</h4>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total:</span>
                        <span><?php echo 'Rp ' . number_format($total_price, 0, ',', '.'); ?></span>
                    </div>
                    <div class="d-grid mt-4">
                         <button type="submit" class="btn btn-success btn-lg">Bayar Sekarang</button>
                    </div>
                    </form> </div>
            </div>
        </div>
    </div>
</div>

<?php include '_includes/footer.php'; ?>