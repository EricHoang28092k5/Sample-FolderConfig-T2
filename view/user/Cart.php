<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/CartContr.php";
$cart = new CartContr();

//giỏ hàng đã được lọc trạng thái(món ăn)
$item = $cart->getCleanCartItems();

// xử lý việc xóa giỏ hàng
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['remove_item']) && isset($_POST['remove_id'])) {
        $maSP = $_POST['remove_id'];
        $cart->handleDeleteItem($maSP);
        header("Location: /web/index.php?act=viewCart"); 
        exit(); 
        
    }
}
if (isset($_SESSION['tenDangNhap'])){
$tenNguoiDung = $_SESSION['tenNguoiDung'];
$tenDangNhap = $_SESSION['tenDangNhap']; 
$email = $_SESSION['email']; 
$password = $_SESSION['password'];
$sdt = $_SESSION['sdt'];
$diaChi = $_SESSION['diaChi'];
$quan_huyen = $_SESSION['quan_huyen'];
$phuong_xa = $_SESSION['phuong_xa'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMTD FOOD</title>
    <link rel="stylesheet" href="/web/view/user/css/Cart.css" /> 
    <link rel="shortcut icon" href="/web/view/img/DMTD-Food-Logo.jpg" type="image/x-icon" />
    <script>
        function updateTotal(id, price) {
            let quantityInput = document.getElementById('quantity-' + id);
            let quantity = parseInt(quantityInput.value);
            
            // Validate quantity input
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
                quantityInput.value = 1;
            } else if (quantity > 100) {
                quantity = 100;
                quantityInput.value = 100;
            }
            
            let totalPrice = parseInt(price) * quantity;
            document.getElementById('total-' + id).innerText = totalPrice.toLocaleString() + " VND";
            
            // Cập nhật tổng tiền
            updateGrandTotal();
            
            // Lưu số lượng vào session thông qua AJAX
            updateQuantityInSession(id, quantity);
        }

        function updateQuantityInSession(id, quantity) {
            // Tạo form data cho AJAX request
            const formData = new FormData();
            formData.append('product_id', id);
            formData.append('quantity', quantity);
            formData.append('update_quantity', 'true');
            formData.append('ajax', 'true');
            
            // Gửi AJAX request
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Đã cập nhật số lượng trong session');
                    // Update the input value if server corrected the quantity
                    if (data.corrected_quantity) {
                        document.getElementById('quantity-' + id).value = data.corrected_quantity;
                        let price = parseInt(document.getElementById('quantity-' + id).getAttribute('data-price'));
                        let totalPrice = price * data.corrected_quantity;
                        document.getElementById('total-' + id).innerText = totalPrice.toLocaleString() + " VND";
                        updateGrandTotal();
                    }
                }
            })
            .catch(error => console.error('Lỗi cập nhật số lượng:', error));
        }

        function updateGrandTotal() {
            let total = 0;
            let totalElements = document.querySelectorAll("[id^='total-']");
            totalElements.forEach(element => {
                total += parseInt(element.innerText.replace(/\D/g, '')); 
            });
            document.getElementById("grand-total").innerText = total.toLocaleString() + " VND";
        }
        
        // Add event listener for direct input and validation
        function validateQuantityInput(input) {
            let value = parseInt(input.value);
            if (isNaN(value) || value < 1) {
                input.value = 1;
            } else if (value > 100) {
                input.value = 100;
            }
        }
    </script>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Header.php";  ?>
<div class="cart-container">
        <h2 class="cart-title">GIỎ HÀNG CỦA BẠN</h2>
        <?php if (empty($item)): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="empty-row">
                        <td colspan="5">
                            <i class="fa-solid fa-cart-shopping empty-cart-icon"></i>
                            Giỏ hàng của bạn đang trống
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="button-group">
                    <button type="button" class="cart-btn continue-btn" onclick="window.location.href='/web/index.php?act=home'">
                        <i class="fa-solid fa-arrow-left"></i> Tiếp tục mua sắm
                    </button>
            </div>
        <?php else: ?>     
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totalAmount = $cart->calculatorCart(); ?>
                    <?php foreach ($item as $id => $product): ?>
                        <?php $itemTotal = $product['gia'] * $product['soluong'];?>                       
                        <tr>
                            <td class="product-name"><?= $product['tenSP'] ?></td>
                            <td>
                                <img class="product-image" src="view/img/product/<?= $product['hinh'] ?>" alt="<?= $product['tenSP'] ?>">
                            </td>
                            <td class="price"><?= number_format($product['gia']) ?> VND</td>
                            <td>
                                <input type="number" id="quantity-<?= $id ?>" class="quantity-input" 
                                    value="<?= $product['soluong'] ?>" min="1" max="100" 
                                    data-price="<?= $product['gia'] ?>"
                                    onchange="updateTotal('<?= $id ?>', '<?= $product['gia'] ?>')"
                                    oninput="validateQuantityInput(this)">
                            </td>
                            <td id="total-<?= $id ?>" class="item-total"><?= number_format($itemTotal) ?> VND</td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="remove_id" value="<?= $id ?>">
                                    <button type="submit" name="remove_item" class="delete-btn">
                                        <i class="fa-solid fa-trash-can"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    
                    <!-- Hàng tổng tiền -->
                    <tr class="grand-total-row">
                        <td colspan="4" class="grand-total-label"><strong>Tổng tiền:</strong></td>
                        <td id="grand-total"><?= number_format($totalAmount) ?> VND</td>
                        <td></td>
                    </tr>
                </tbody>
            </table> 
                <div class="button-group">
                    <button type="button" class="cart-btn continue-btn" onclick="window.location.href='/web/index.php?act=home'">
                        <i class="fa-solid fa-arrow-left"></i> Tiếp tục mua sắm
                    </button>
                    <button type="button" class="cart-btn checkout-btn" onclick= "window.location.href='/web/index.php?act=checkOrder'">
                        <i class="fa-solid fa-check"></i> Xác nhận đặt hàng
                    </button>
                </div>                    
                </div>
        <?php $dataUser = [
            "tenNguoiDung" => $tenNguoiDung,
            "sdt" => $sdt,
            "email" => $email,
            "diaChi" => $diaChi,
            "quan_huyen" => $quan_huyen,
            "phuong_xa" => $phuong_xa,
            "tongTien" => $totalAmount
        ];
            $_SESSION['infoUser'] = $dataUser;
        ?>
        <?php endif; ?>
        
        
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Footer.php"; ?>            
</body>
</html>