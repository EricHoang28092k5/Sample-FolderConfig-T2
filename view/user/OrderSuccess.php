<?php
if(isset($_SESSION['orderInfo'])){
    $row = $_SESSION['orderInfo'];

    $tenNguoiDung = $row['tenNguoiDung'];
    $email = $row['email'];
    $sdt = $row['sdt'];
    $diaChi = $row['diaChi'];
    $quan_huyen = $row['quan_huyen'];
    $phuong_xa = $row['phuong_xa'];
    $pttt = $row['pttt'];
    $tongTien = $row['tongTien'];
    $ngayDatHang = $row['date'];
    $donHang = $row['order_item'];
    $order_success = $row['order_success'];

}else{
    $_SESSION['error_message'] = "Không tìm thấy thông tin đơn hàng trong hệ thống!";
    header("Location: /web/index.php");
    exit();
}

// Kiểm tra xem người dùng đã đặt hàng thành công hay chưa
if (!isset($order_success) || $order_success !== true) {
    header("Location: /web/index.php");
    exit();
}

$maHoaDon = isset($_SESSION['maHoaDon']) ? $_SESSION['maHoaDon'] : 0;
if ($maHoaDon <= 0) {
    $_SESSION['error_message'] = "Không tìm thấy thông tin đơn hàng!";
    header("Location: /web/index.php");
    exit();
}


// Hàm chuyển đổi phương thức thanh toán
function getPhuongThucThanhToan($value) {
    switch ($value) {
        case 1:
            return "Thanh toán khi giao hàng (COD)";
        default:
            return "Không xác định";
    }
}


// Xóa thông tin đơn hàng khỏi session để tránh hiển thị lại khi refresh
// Giữ lại maHoaDon để xem chi tiết đơn hàng sau này
// unset($order_success);
// unset($_SESSION['order_info']);
// unset($order_items);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="shortcut icon" href="/web/view/img/DMTD-Food-Logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="/web/view/user/css/OrderSuccess.css" /> 
    <title>DMTD FOOD</title>
</head>
<body>
    <div class="container">
        <div class="success-header">
            <div class="logo">DMTD FOOD</div>
            <div class="order-id">Đơn hàng: <strong>#<?php echo $maHoaDon; ?></strong></div>
        </div>
        
        <div class="success-icon">
            <div class="checkmark"><i class="fas fa-check"></i></div>
        </div>
        
        <div class="success-message">
            <h1>Cảm ơn bạn đã đặt hàng</h1>
            <p>Một email xác nhận đã được gửi tới <?php echo $email; ?>.<br>Xin vui lòng kiểm tra email của bạn</p>
        </div>
        
        <div class="order-details">
            <div class="order-section">
                <h2>Thông tin mua hàng</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="label">Họ và tên:</div>
                        <div class="value"><?php echo $tenNguoiDung; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="label">Email:</div>
                        <div class="value"><?php echo $email; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="label">Số điện thoại:</div>
                        <div class="value"><?php echo $sdt; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="label">Ngày đặt hàng:</div>
                        <div class="value"><?php echo $ngayDatHang; ?></div>
                    </div>
                </div>
            </div>
            
            <div class="order-section">
                <h2>Địa chỉ giao hàng</h2>
                <div class="info-item">
                    <div class="value">
                        <?php echo $diaChi; ?>, <?php echo $phuong_xa; ?>, <?php echo $quan_huyen; ?>
                    </div>
                </div>
            </div>
            
            <div class="order-section">
                <h2>Phương thức thanh toán</h2>
                <div class="info-item">
                    <div class="value">
                        <?php echo getPhuongThucThanhToan($pttt); ?>
                    </div>
                </div>
            </div>
            
            <div class="order-section order-summary">
                <h2>Đơn hàng #<?php echo $maHoaDon; ?></h2>
                
                <table class="order-summary-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        if(!empty($donHang)):
                            foreach($donHang as $id => $item):
                                $itemTotal = $item['gia'] * $item['soluong'];
                                $total += $itemTotal;
                        ?>
                        <tr>
                            <td class="product-name"><?php echo $item['tenSP']; ?></td>
                            <td><img src="/web/view/img/product/<?php echo $item['hinh']; ?>" alt="<?php echo $item['tenSP']; ?>" class="product-img"></td>
                            <td><?php echo number_format($item['gia']); ?>₫</td>
                            <td><?php echo $item['soluong']; ?></td>
                            <td><?php echo number_format($itemTotal); ?>₫</td>
                        </tr>
                        <?php 
                            endforeach;
                        elseif(!empty($_SESSION['giohang'])):
                            foreach($_SESSION['giohang'] as $product):
                                $itemTotal = $product[3] * $product[4];
                                $total += $itemTotal;
                        ?>
                        <tr>
                            <td class="product-name"><?php echo $product[2]; ?></td>
                            <td><img src="../view/img/product/<?php echo $product[1]; ?>" alt="<?php echo $product[2]; ?>" class="product-img"></td>
                            <td><?php echo number_format($product[3]); ?>₫</td>
                            <td><?php echo $product[4]; ?></td>
                            <td><?php echo number_format($itemTotal); ?>₫</td>
                        </tr>
                        <?php 
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
                
                <div class="order-total">
                    <div class="total-label">Tổng cộng:</div>
                    <div class="total-value"><?php echo number_format($tongTien); ?>₫</div>
                </div>
            </div>
        </div>
        
        <div class="actions">
            <a href="/web/index.php?act=home" class="btn btn-home">Tiếp tục mua hàng</a>
            <a href="javascript:window.print()" class="btn btn-print"><i class="fas fa-print"></i> In</a>
        </div>
    </div>
</body>
</html>