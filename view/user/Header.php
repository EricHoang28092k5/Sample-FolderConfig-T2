<?php
$tenDangNhap = '';

if(isset($isLoggedIn) && $isLoggedIn){
  $tenDangNhap = $_SESSION['tenDangNhap']; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <!-- Đường dẫn theo file index.php -->
    <link rel="stylesheet" href="view/user/css/Header.css" /> 
    <title>DMTD FOOD</title>
</head>
<body>

<div class="header-banner">60 phút - Giao ngay tận nơi</div>

<!-- header  -->
    <header class="header-top">
      <div class="container">
      <div class="logo">
  <a href="#" class="logo-img"><img height="70" src="view/img/DMTD-Food-Logo.jpg" alt="Logo"/></a>
  <span><b>DMTD FOOD</b></span>
</div>

<!-- PHẦN CỦA DŨNG -->
<form id="product-search" method="GET">
  <div class="box">
    <input type="text" placeholder="Tìm kiếm thức ăn" name="search" 
           value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" />
    <button type="submit" class="search-btn">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
    <button type="button" class="search-btn" onclick="openAdvancedSearch()" title="Tìm kiếm nâng cao">
        <i class="fa-solid fa-sliders"></i>
    </button>
  </div>
</form>

<!-- Lớp phủ mờ nền -->
<div id="overlay" class="overlay" onclick="closeAdvancedSearch()"></div>

<!-- Popup tìm kiếm nâng cao -->
<div id="advanced-popup" class="advanced-popup">
  <div class="popup-content">
    <span class="close-btn" onclick="closeAdvancedSearch()">&times;</span>
    <h3>Tìm kiếm nâng cao</h3>
    <form method="GET" style="display: flex; flex-direction: column; gap: 10px;">
    <label>Tên sản phẩm:</label>
      <input type="text" name="search" placeholder="Tìm theo tên sản phẩm" 
             value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
      <label>Danh mục:</label>
      <select name="MaLoaiSP">
        <option value="0">-- Tất cả --</option>
        <option value="1" <?= ($maLoaiSP == 1) ? 'selected' : '' ?>>Món mặn</option>
        <option value="2" <?= ($maLoaiSP == 2) ? 'selected' : '' ?>>Món chay</option>
        <option value="3" <?= ($maLoaiSP == 3) ? 'selected' : '' ?>>Món lẩu</option>
        <option value="4" <?= ($maLoaiSP == 4) ? 'selected' : '' ?>>Nước uống</option>
      </select>

      <label>Khoảng giá:</label>
      <input type="range" name="min_price" id="min_price" min="0" max="500000" step="10000"
             value="<?= $min_price ?>" oninput="updatePriceLabel()">
      <input type="range" name="max_price" id="max_price" min="0" max="500000" step="10000"
             value="<?= $max_price ?>" oninput="updatePriceLabel()">
      <div id="priceLabel" style="font-weight:bold;"></div>

      <button type="submit" class="search-btn" style="background: #f37319; color: white; padding: 8px; border-radius: 5px;">
        Tìm kiếm
      </button>
    </form>
  </div>
</div>
<!-- ================== -->

 <!-- PHẦN CỦA DƯƠNG -->
<div class="action">
          <div class="item">
            <a href="#"><i class="fa-regular fa-user"></i></a>
            <?php if(isset($isLoggedIn) && $isLoggedIn): ?>
              <span><?php echo $tenDangNhap; ?></span>
            <?php endif; ?>
            <ul class="item_menu">
              <?php if(isset($isLoggedIn) && $isLoggedIn): ?>
                <li class="heder_item_user">
                  <a href="../view/info.php">Thông tin cá nhân</a>
                </li>
                <li class="heder_item_user">
                  <a href="../controller/index.php?act=xemhoadon">Xem hóa đơn</a>
                </li>
                <li class="heder_item_user">
                  <a href="LogOut.php">Đăng xuất</a>
                </li>
              <?php else: ?>
                <li class="heder_item_user">
                  <a href="view/user/SignIn.php">Đăng nhập</a>
                </li>
                <li class="heder_item_user">
                  <a href="view/user/SignUp.php">Đăng ký</a>
                </li>
              <?php endif; ?>
            </ul>
          </div>
          <div class="item">
            <a href="Cart.php"
              ><i class="fa-solid fa-cart-shopping"></i
            ></a>
          </div>
        </div>
      </div>
    </header>

    <!-- PHẦN CỦA DŨNG -->
    <nav>
  <ul>
    <li><a href="../controller/index.php">Trang chủ</a></li>
    <li><a href="../controller/index.php?MaLoaiSP=1">Món mặn</a></li>
    <li><a href="../controller/index.php?MaLoaiSP=2">Món chay</a></li>
    <li><a href="../controller/index.php?MaLoaiSP=3">Món lẩu</a></li>
    <li><a href="../controller/index.php?MaLoaiSP=4">Nước uống</a></li>
  </ul>
</nav>

<script>
    function openAdvancedSearch() {
    document.getElementById("overlay").style.display = "block";
    document.getElementById("advanced-popup").style.display = "block";
    updatePriceLabel();
  }

  function closeAdvancedSearch() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("advanced-popup").style.display = "none";
  }

  function updatePriceLabel() {
    const min = document.getElementById("min_price").value;
    const max = document.getElementById("max_price").value;
    document.getElementById("priceLabel").innerText =
      `Từ ${Number(min).toLocaleString()} đ đến ${Number(max).toLocaleString()} đ`;
  }

</script>


