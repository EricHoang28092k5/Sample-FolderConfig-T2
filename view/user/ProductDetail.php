<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/ProductContr.php";

if (isset($_GET['product_id'])) {
    $productController = new ProductContr();
    $product = $productController->getProductById($_GET['product_id']);

    if ($product) {
        ?>
        <div class="product-detail-container">
            <h2><?= htmlspecialchars($product['TenSP']) ?></h2>
            <div class="product-detail-content">
                <img src="/web/view/img/product/<?= htmlspecialchars($product['HinhAnh']) ?>" 
                     alt="<?= htmlspecialchars($product['TenSP']) ?>">
                <p><?= nl2br(htmlspecialchars($product['MoTa'])) ?></p>
                <div class="product-price">
                    Giá: <span class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?> đ</span>
                </div>
                <form action="/web/inc/user/CartInc.php" method="post">
                    <input type="hidden" name="id" value="<?= $product['MaSP'] ?>">
                    <input type="hidden" name="tensp" value="<?= htmlspecialchars($product['TenSP']) ?>">
                    <input type="hidden" name="gia" value="<?= $product['DonGia'] ?>">
                    <input type="hidden" name="hinh" value="<?= htmlspecialchars($product['HinhAnh']) ?>">
                    <label for="quantity">Số lượng:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1">
                    <input type="submit" name="addcart" value="Đặt hàng">
                </form>
            </div>
        </div>
        <?php
    } else {
        echo "<p>Không tìm thấy sản phẩm.</p>";
    }
} else {
    echo "<p>Yêu cầu không hợp lệ.</p>";
}
?>
