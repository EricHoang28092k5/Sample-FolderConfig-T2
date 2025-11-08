<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="view/user/css/Home.css"/>
    <link
      rel="shortcut icon"
      href="view/img/DMTD-Food-Logo.jpg"
      type="image/x-icon"
    />
    <title>DMTD FOOD</title>
</head>
<body>
    <!-- NHÚNG HEADER -->
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Header.php"; ?>

    <div class="banner">
    <img src="view/img/banner.png" alt="banner">
  </div>


<section>
    <div id="wrapper">
        <div class="headline">
            <div class="section-title">Khám phá thực đơn của chúng tôi</div>
            <div class="header-underline"></div>
        </div>
   
<!-- PHẦN CỦA DƯƠNG -->

<!-- HIỆN SẢN PHẨM -->
<ul class="products">
    <?php
    require_once "controller/user/ProductContr.php"; 
    $products = new ProductContr();
    $productList = $products->showAllProducts();
    if(!empty($productList)): 
    ?>
        <?php foreach ($productList as $product): ?>
            <div class="products-item">
                <li>
                    <div class="product-top">
                        <a href="javascript:void(0)" class="product-thumb" onclick="openProductDetail(<?= $product['MaSP'] ?>)">
                            <img src="view/img/product/<?= htmlspecialchars($product['HinhAnh']) ?>" alt="<?= htmlspecialchars($product['TenSP']) ?>">
                        </a>
                    </div>
                    <div class="product-info">
                        <a href="javascript:void(0)" class="product-name" onclick="openProductDetail(<?= $product['MaSP'] ?>)">
                            <?= htmlspecialchars($product['TenSP']) ?>
                        </a>
                        <div class="product-price">
                            <span class="price"><?= number_format($product['DonGia'], 0, ',', '.') ?><span class="currency">đ</span></span>
                        </div>
                        <form action="/web/inc/user/CartInc.php" method="post">
                            <input type="hidden" name="id" value="<?= $product['MaSP'] ?>">
                            <input type="hidden" name="tensp" value="<?= htmlspecialchars($product['TenSP']) ?>">
                            <input type="hidden" name="gia" value="<?= $product['DonGia'] ?>">
                            <input type="hidden" name="hinh" value="<?= htmlspecialchars($product['HinhAnh']) ?>">
                            <input type="submit" name="addcart" value="Đặt hàng">
                        </form>
                    </div>
                </li>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Không có sản phẩm nào!</p>
    <?php endif; ?>
</ul>

      <!-- Popup hiển thị chi tiết sản phẩm -->
      <div id="product-detail-popup" class="product-popup">
        <span class="close-btn" onclick="closeProductDetail()">&times;</span>
        <div class="popup-content">
          <div id="product-detail-content">
            <!-- Nội dung chi tiết sản phẩm sẽ được load động -->
          </div>
        </div>
      </div>

      <div id="product-overlay" class="overlay" onclick="closeProductDetail()"></div>

      <?php include $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Pagination.php"; ?>
    </div>
  </section>

  <!-- FOOTER -->
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Footer.php"; ?>


  <!-- 🟢 SCRIPT: load chi tiết sản phẩm bằng fetch -->
  <script>
  function showProductDetail(productId) {
      fetch(`/web/view/user/ProductDetail.php?product_id=${productId}`)
          .then(response => response.text())
          .then(data => {
              document.getElementById("product-detail-content").innerHTML = data;
              document.getElementById("product-detail-popup").style.display = "block";
              document.getElementById("product-overlay").style.display = "block";
          });
  }

  function closeProductDetail() {
      document.getElementById("product-detail-popup").style.display = "none";
      document.getElementById("product-overlay").style.display = "none";
  }
  </script>


<?php 
if (isset($_GET['act'])){
    $typeAct = $_GET['act'];
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {';    
    switch($typeAct){
        case "notSignIn":
            echo 'showNotSignInModal("Vui lòng đăng nhập để thêm giỏ hàng");';
            break;
        case "addToCartSuccess":
           echo 'showAddToCartModal("Thêm món ăn thành công");';
           break;
    }
    echo '});
    </script>';    
}
?>


<script>
// === MODAL THÔNG BÁO LỖI ĐĂNG NHẬP ===
function showNotSignInModal(message) {
  createModal(message, "/web/view/user/SignIn.php", "Đăng nhập");
}

function showAddToCartModal(message) {
  createModal(message, "/web/index.php?act=viewCart", "Xem giỏ hàng");
}

// === HÀM TẠO MODAL DÙNG CHUNG ===
function createModal(message, linkHref, linkText) {
  const modalContainer = document.createElement("div");
  modalContainer.id = "modal-container";

  modalContainer.innerHTML = `
    <div class="modal" id="modal-demo">
      <div class="modal_header">
        <h3>Thông báo</h3>
        <button id="btn-close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal_body">
        <p>${message}</p>
        <a href="${linkHref}">${linkText}</a>
      </div>
    </div>
  `;

  document.body.appendChild(modalContainer);

  const btnClose = document.getElementById("btn-close");
  const modalDemo = document.getElementById("modal-demo");

  modalContainer.classList.add("show");

  btnClose.addEventListener("click", function () {
    modalContainer.classList.remove("show");
    setTimeout(() => document.body.removeChild(modalContainer), 300);
  });

  modalContainer.addEventListener("click", function (e) {
    if (!modalDemo.contains(e.target)) btnClose.click();
  });

  // === THÊM CSS CHO MODAL (nếu chưa có) ===
  if (!document.getElementById("modal-style")) {
    const style = document.createElement("style");
    style.id = "modal-style";
    style.textContent = `
      * { box-sizing: border-box; }
      body { font-family: Arial, Helvetica, sans-serif; line-height: 1.3; }

      #modal-container {
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0; left: 0;
        width: 100%;
        opacity: 0;
        pointer-events: none;
        z-index: 1000;
      }
      #modal-container.show { opacity: 1; pointer-events: all; }

      .modal {
        background-color: #fff;
        max-width: 500px;
        position: relative;
        left: 50%; top: 100px;
        transform: translateX(-50%);
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      }

      .modal .modal_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid gray;
      }

      .modal_header h3 {
        margin: 0;
        text-align: center;
        flex-grow: 1;
      }

      button#btn-close {
        width: 30px; height: 30px;
        border: none;
        font-size: 20px;
        color: white;
        background-color: #f37319;
        border-radius: 20px;
        cursor: pointer;
        position: absolute;
        top: -5px; right: -5px;
      }

      .modal .modal_body { padding: 10px 20px 15px; }

      .modal_body p { text-align: center; }

      .modal_body a {
        text-decoration: none;
        background: #f37319;
        color: #fff;
        display: block;
        padding: 5px 15px;
        text-align: center;
        margin: 10px auto;
        width: fit-content;
        border-radius: 10px;
      }
    `;
    document.head.appendChild(style);
  }
}
</script>


<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Footer.php"; ?>
</body>
</html>
