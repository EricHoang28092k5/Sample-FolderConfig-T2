<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/BillContr.php";
$bill = new BillContr();
$isLoggedIn = isset($_SESSION['tenDangNhap']);
$email = $_SESSION['email'] ?? null;
$billsData = [];

if($isLoggedIn && $email){
    $IdNguoiDung = $bill->getUserId($email);
    
    if($IdNguoiDung > 0){
        $billsData = $bill->getAllBill($IdNguoiDung);
        $_SESSION['hoadon'] = $billsData;
    } else {
        $_SESSION['hoadon'] = [];
    }
} else {
    echo "Không có dữ liệu đăng nhập";
    exit();
}

function formatDate($dateString) {
    $date = new DateTime($dateString);
    return $date->format('d/m/Y');
}

function getPhuongThucThanhToan($value) {
    switch ($value) {
        case 1:
            return "Tiền mặt";
        default:
            return "Không xác định";
    }
}

function getTrangThaiDonHang($value) {
    switch ($value) {
        case 1:
            return "<span class='status-pending'>Chưa xác nhận</span>";
        case 2:
            return "<span class='status-confirmed'>Đã xác nhận</span>";
        case 3:
            return "<span class='status-delivered'>Đã giao</span>";
        case 4:
            return "<span class='status-cancelled'>Đã hủy</span>";
        default:
            return "Không xác định";
    }
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="/web/view/user/css/Bill.css" />
    <link
      rel="shortcut icon"
      href="/web/view/img/DMTD-Food-Logo.jpg"
      type="image/x-icon"
    /> 
    <title>DMTD FOOD</title>
</head>
<body>
    <div class="bill-container">
        <h2 class="page-title">ĐƠN HÀNG CỦA TÔI</h2>
        
        <?php if(!empty($billsData)): ?>
            <table class="order-table">
                <tr>
                    <th>Đơn hàng</th>
                    <th>Ngày</th>
                    <th>Địa chỉ</th>
                    <th>Giá trị đơn hàng</th>
                    <th>Hình thức thanh toán</th>
                    <th>Trạng thái đơn hàng</th>
                </tr>
                <?php foreach ($billsData as $hoadon): ?> 
                    <tr>
                        <td>
                            <a href="/web/view/user/BillDetail.php?mahoadon=<?= $hoadon['IdHoaDon'] ?>" class="order-link">
                                #<?= $hoadon['IdHoaDon'] ?>
                            </a>
                        </td>
                        <td><?= formatDate($hoadon['NgayDatHang']) ?></td>
                        <td><?= $hoadon['DiaChi'] . ', ' . $hoadon['quan_huyen'] . ', ' . $hoadon['phuong_xa'] ?></td>
                        <td><?= number_format($hoadon['TongTien'], 0, ',', '.') ?>₫</td>
                        <td><?= getPhuongThucThanhToan($hoadon['PhuongThucTT']) ?></td>
                        <td><?= getTrangThaiDonHang($hoadon['TrangThai']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
            <div class="button-container">
                <button type="button" class="shop-button" onclick="window.location.href='/web/index.php?act=home'">Tiếp tục mua sắm</button>
            </div>
            
        <?php else: ?>
            <?php endif; ?>
    </div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Footer.php"; ?>   
</body>
</html>
