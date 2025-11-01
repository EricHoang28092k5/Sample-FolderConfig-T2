<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/BillContr.php";

if(isset($_SESSION['tenDangNhap'])){
$tenNguoiDung = $_SESSION['tenNguoiDung'];
$sdt = $_SESSION['sdt'];
$diaChi = $_SESSION['diaChi'];
$quan_huyen = $_SESSION['quan_huyen'];
$phuong_xa = $_SESSION['phuong_xa'];
}

$maHoaDon = isset($_GET['mahoadon']) ? $_GET['mahoadon'] : 0;

if($maHoaDon <= 0) {
    echo "Không tìm thấy đơn hàng";
    exit();
}

$bill = new BillContr();
$donHang = $bill->handleGetBillDetail($maHoaDon);
$summary = $bill->getBillSummaryInfo($maHoaDon);
if(!$summary) {
    echo "Không tìm thấy thông tin đơn hàng!";
    exit();
}
$pttt = $summary['PhuongThucTT'];
$trangThai = $summary['TrangThai'];
$tongTien = $summary['TongTien'];
$ngayDatHang= $summary['NgayDatHang'];

function getTrangThaiThanhToan($value) {
    switch ($value) {
        case 1:
            return "<span class='status-value not-paid'>Chưa thanh toán</span>";
        case 2:
            return "<span class='status-value paid'>Đã thanh toán</span>";
        default:
            return "Không xác định";
    }
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
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="shortcut icon"
      href="/web//view/img/DMTD-Food-Logo.jpg"
      type="image/x-icon"
    />
    <link rel="stylesheet" href="/web/view/user/css/BillDetail.css" />
    <title>DMTD FOOD</title>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Header.php";  ?>

    <div class="order-details-container">
        <div class="order-header">
            <h1>Chi tiết đơn hàng #<?php echo $maHoaDon; ?></h1>
            <div class="order-date">Ngày đặt hàng: <?php echo $ngayDatHang; ?></div>
        </div>

        <div class="section">
            <div class="section-title">ĐỊA CHỈ GIAO HÀNG</div>
            <div class="info-box">
                <div class="customer-name"><?php echo $tenNguoiDung; ?></div>
                <div>Địa chỉ: <?php echo $diaChi . ', ' . $phuong_xa . ', ' . $quan_huyen; ?></div>
                <div>Số điện thoại: <?php echo $sdt; ?></div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">PHƯƠNG THỨC THANH TOÁN</div>
            <div class="info-box">
                <?php echo getPhuongThucThanhToan($pttt); ?>
            </div>
        </div>

        <div class="section">
            <div class="section-title">CHI TIẾT ĐƠN HÀNG</div>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($donHang as $id => $item): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center;" class="product-flex">
                                <img src="/web/view/img/product/<?php echo $item['HinhAnh']; ?>" class="product-image" alt="<?php echo $item['TenSP']; ?>">
                                <div style="margin-left: 15px;" class="product-details">
                                    <div class="product-name"><?php echo $item['TenSP']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?php echo number_format($item['DonGia'], 0, ',', '.'); ?>₫</td>
                        <td><?php echo $item['SoLuong']; ?></td>
                        <td><?php echo number_format($item['DonGia'] * $item['SoLuong'], 0, ',', '.'); ?>₫</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <table class="summary-table">
                <tr class="subtotal-row">
                    <td>Tổng thanh toán</td>
                    <td class="text-right"><?php echo number_format($tongTien, 0, ',', '.'); ?>₫</td>
                </tr>
            </table>
        </div>

        <div class="button-container">
            <a href="/web/index.php?act=home" class="shop-button">Tiếp tục mua sắm</a>
        </div>
    </div>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Header.php";  ?>
</body>
</html>