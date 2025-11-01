<?php
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

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/CartContr.php";
$cart = new CartContr();
$item = $cart->handleViewCart();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/web/view/user/css/CheckOrder.css" /> 
    <link
      rel="shortcut icon"
      href="/web/view/img/DMTD-Food-Logo.jpg"
      type="image/x-icon"
    />
    <title>DMTD FOOD</title>
<script>
// Cập nhật danh sách huyện khi quận thay đổi
function updateHuyen() {
            const quanHuyen = document.getElementById("quan_huyen").value;
            const phuongXaSelect = document.getElementById("phuong_xa");
            
            // Xóa tất cả các phường/xã hiện tại
            phuongXaSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
            
            // Danh sách phường/xã theo quận/huyện
            const phuongXaList = {
                "Quận 1": ["Phường Bến Nghé", "Phường Bến Thành", "Phường Cầu Kho", "Phường Cầu Ông Lãnh", "Phường Đa Kao"],
                "Quận 3": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5"],
                "Quận 4": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5"],
                "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5"],
                "Quận 6": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 7"],
                "Quận 7": ["Phường Tân Thuận Đông", "Phường Tân Thuận Tây", "Phường Tân Kiểng", "Phường Tân Hưng", "Phường Tân Phú"],
                "Quận 8": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5"],
                "Quận 10": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5"],
                "Quận 11": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5"],
                "Quận 12": ["Phường Tân Chánh Hiệp", "Phường Tân Thới Hiệp", "Phường Thạnh Xuân", "Phường Thới An", "Phường Hiệp Thành"],
                "Quận Bình Tân": ["Phường An Lạc", "Phường An Lạc A", "Phường Bình Trị Đông", "Phường Bình Trị Đông A", "Phường Bình Trị Đông B"],
                "Quận Bình Thạnh": ["Phường 1", "Phường 2", "Phường 3", "Phường 5", "Phường 6"],
                "Quận Gò Vấp": ["Phường 1", "Phường 3", "Phường 4", "Phường 5", "Phường 6"],
                "Quận Phú Nhuận": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5"],
                "Quận Tân Bình": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5"],
                "Quận Tân Phú": ["Phường Tân Sơn Nhì", "Phường Tây Thạnh", "Phường Sơn Kỳ", "Phường Tân Quý", "Phường Tân Thành"],
                "Thành phố Thủ Đức": ["Phường Linh Trung", "Phường Tam Phú", "Phường Hiệp Bình Phước", "Phường Linh Đông", "Phường Tam Bình"],
                "Huyện Bình Chánh": ["Xã An Phú Tây", "Xã Bình Chánh", "Xã Bình Hưng", "Xã Bình Lợi", "Xã Đa Phước"],
                "Huyện Củ Chi": ["Xã An Nhơn Tây", "Xã An Phú", "Xã Bình Mỹ", "Xã Hòa Phú", "Xã Nhuận Đức"],
                "Huyện Nhà Bè": ["Xã Hiệp Phước", "Xã Long Thới", "Xã Nhơn Đức", "Xã Phú Xuân", "Xã Phước Kiển"]
            };
            
            // Thêm các phường/xã cho quận/huyện đã chọn
            if (quanHuyen && phuongXaList[quanHuyen]) {
                phuongXaList[quanHuyen].forEach(phuongXa => {
                    const option = document.createElement("option");
                    option.value = phuongXa;
                    option.textContent = phuongXa;
                    phuongXaSelect.appendChild(option);
                });
            }
        }
</script>
</head>
<body>
    
<div class="container">
<h2>THÔNG TIN ĐẶT HÀNG</h2>
<form action="/web/inc/user/OrderInc.php" method="post">
    <table class="info-table">
      <tr>
        <th>Họ và tên</th>
        <td><input type="text" name="tenNguoiDung" value="<?=$tenNguoiDung?>" placeholder="Họ và tên"  required></td>
      </tr>
      <input type="hidden" name="email" value="<?=$email?>"  placeholder="Email" required>
      <tr>
        <th>Số điện thoại</th>
        <td><input type="text" name="sdt" value="<?=$sdt?>" placeholder="Số điện thoại" pattern="^0[1-9][0-9]{8,10}$" required></td>
      </tr>
      <tr>
        <th>Địa chỉ</th>
        <td><input type="text" name="diaChi" value="<?=$diaChi?>" placeholder="Địa chỉ" required></td>
      </tr>
      <tr>
        <th>Quận/Huyện</th>
        <td>
          <div class="input-container">
          <select class="input-field" id="quan_huyen" name="quan_huyen" onchange="updateHuyen()" required>
            <?php if(empty($quan_huyen)): ?>
              <option value="">Chọn quận/huyện</option>
            <?php endif; ?>
            <option value="Quận 1" <?=($quan_huyen == 'Quận 1') ? 'selected' : ''?>>Quận 1</option>
            <option value="Quận 3" <?=($quan_huyen == 'Quận 3') ? 'selected' : ''?>>Quận 3</option>
            <option value="Quận 4" <?=($quan_huyen == 'Quận 4') ? 'selected' : ''?>>Quận 4</option>
            <option value="Quận 5" <?=($quan_huyen == 'Quận 5') ? 'selected' : ''?>>Quận 5</option>
            <option value="Quận 6" <?=($quan_huyen == 'Quận 6') ? 'selected' : ''?>>Quận 6</option>
            <option value="Quận 7" <?=($quan_huyen == 'Quận 7') ? 'selected' : ''?>>Quận 7</option>
            <option value="Quận 8" <?=($quan_huyen == 'Quận 8') ? 'selected' : ''?>>Quận 8</option>
            <option value="Quận 10" <?=($quan_huyen == 'Quận 10') ? 'selected' : ''?>>Quận 10</option>
            <option value="Quận 11" <?=($quan_huyen == 'Quận 11') ? 'selected' : ''?>>Quận 11</option>
            <option value="Quận 12" <?=($quan_huyen == 'Quận 12') ? 'selected' : ''?>>Quận 12</option>
            <option value="Quận Bình Tân" <?=($quan_huyen == 'Quận Bình Tân') ? 'selected' : ''?>>Quận Bình Tân</option>
            <option value="Quận Bình Thạnh" <?=($quan_huyen == 'Quận Bình Thạnh') ? 'selected' : ''?>>Quận Bình Thạnh</option>
            <option value="Quận Gò Vấp" <?=($quan_huyen == 'Quận Gò Vấp') ? 'selected' : ''?>>Quận Gò Vấp</option>
            <option value="Quận Phú Nhuận" <?=($quan_huyen == 'Quận Phú Nhuận') ? 'selected' : ''?>>Quận Phú Nhuận</option>
            <option value="Quận Tân Bình" <?=($quan_huyen == 'Quận Tân Bình') ? 'selected' : ''?>>Quận Tân Bình</option>
            <option value="Quận Tân Phú" <?=($quan_huyen == 'Quận Tân Phú') ? 'selected' : ''?>>Quận Tân Phú</option>
            <option value="Thành phố Thủ Đức" <?=($quan_huyen == 'Thành phố Thủ Đức') ? 'selected' : ''?>>Thành phố Thủ Đức</option>
            <option value="Huyện Bình Chánh" <?=($quan_huyen == 'Huyện Bình Chánh') ? 'selected' : ''?>>Huyện Bình Chánh</option>
            <option value="Huyện Củ Chi" <?=($quan_huyen == 'Huyện Củ Chi') ? 'selected' : ''?>>Huyện Củ Chi</option>
            <option value="Huyện Nhà Bè" <?=($quan_huyen == 'Huyện Nhà Bè') ? 'selected' : ''?>>Huyện Nhà Bè</option>
          </select>
        </div>             
        </td>
      </tr>
      <tr>
        <th>Phường/Xã</th>  
        <td>
        <div class="input-container">
            <select class="input-field" id="phuong_xa" name="phuong_xa" required>
                <option value="<?=$phuong_xa?>"><?=empty($phuong_xa) ? "Chọn phường/xã" : $phuong_xa?></option>
            </select>
          </div>
        </td>
      </tr>

      <tr>
        <th>Phương thức thanh toán</th>
        <td>
        <select name="pttt" required>
            <option value="1">Thanh toán khi nhận hàng</option>
            </select>
        </td>
      </tr>
    </table>

   <!-- Phần xem lại giỏ hàng -->
   <div class="cart-review">
   <h2>XEM LẠI GIỎ HÀNG</h2>
    <table class="cart-table" border="1">
      <tr>
        <th>Sản phẩm</th>
        <th>Hình ảnh</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
      </tr>
      
      <?php
      $tongTien = 0;
      foreach ($item as $id => $product): 
          $itemTotal = $product['gia'] * $product['soluong'];
          $tongTien += $itemTotal;
      ?>
      <tr>
        <td><?= $product['tenSP'] ?></td>
        <td><img src="/web/view/img/product/<?= $product['hinh'] ?>" alt="<?= $product['tenSP'] ?>" width="80"></td>
        <td><?= number_format($product['gia']) ?> VND</td>
        <td><?= $product['soluong'] ?></td>
        <td><?= number_format($itemTotal) ?> VND</td>
      </tr>
      <?php endforeach; ?>
      
      <tr>
        <td colspan="4" align="right"><strong>Tổng tiền:</strong></td>
        <td style="color:red;"><?= number_format($tongTien) ?> VND</td>
        <input type="hidden" name="tongTien" value="<?=$tongTien ?>">
      </tr>
    </table>
    
    <div class="cart-footer">
      <a href="/web/index.php?act=viewCart" class="back-btn">Quay lại giỏ hàng</a>
      <input type="submit" name="thanhtoan" value="Xác nhận đặt hàng">
    </div>
  </div>
  </form>  
</body>
</html>