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
<?php
if (isset($_GET['act'])) {
    $act = $_GET['act'];
    
    echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    
    switch ($act) {
        case 'addToCartSuccess':
            // KHÔNG CÓ LINK: Chỉ cần thông báo và nút OK
            echo 'showCartSuccessModal("Sản phẩm đã được thêm vào giỏ hàng thành công!");';
            // Xóa tham số khỏi URL sau khi hiển thị modal để ngăn modal hiện lại khi F5
            echo 'window.history.replaceState({}, document.title, "/web/index.php");'; 
            break;

        case 'notSignIn':
            // CÓ LINK: Hiện thông báo và nút chuyển hướng Đăng nhập
            echo 'showNotSignedInModal("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!");';
            echo 'window.history.replaceState({}, document.title, "/web/index.php");';
            break;
    }

    echo '});';
    echo '</script>';
}
?>
<script>
function createModal(message, linkHref, linkText) {
    const modalContainer = document.createElement("div");
    modalContainer.id = "modal-container";
    
    const hasLink = linkHref && linkText;

    // Sửa HTML: Sử dụng nút OK khi không có link
    modalContainer.innerHTML = `
      <div class="modal" id="modal-demo">
        <div class="modal_header">
          <h3>Thông báo</h3>
          <button id="btn-close">&times;</button>
        </div>
        <div class="modal_body">
          <p>${message}</p>
          ${hasLink 
            ? `<a href="${linkHref}">${linkText}</a>` 
            : `<button id="btn-close-body" class="modal-ok-button">OK</button>` 
          }
        </div>
      </div>
    `;

    document.body.appendChild(modalContainer);

    const btnClose = document.getElementById("btn-close");
    const modalDemo = document.getElementById("modal-demo");
    const btnCloseBody = document.getElementById("btn-close-body");

    // Thêm class show và xử lý đóng
    setTimeout(() => modalContainer.classList.add("show"), 10); 

    const closeHandler = () => {
        modalContainer.classList.remove("show");
        setTimeout(() => {
            if (document.body.contains(modalContainer)) {
                document.body.removeChild(modalContainer);
            }
        }, 300);
    };

    btnClose.addEventListener("click", closeHandler);
    if (btnCloseBody) {
        btnCloseBody.addEventListener("click", closeHandler);
    }
    
    modalContainer.addEventListener("click", function (e) {
      if (e.target === modalContainer) {
          closeHandler();
      }
    });
}

// === CÁC HÀM GỌI CỤ THỂ ===

// 1. Trường hợp: Thêm giỏ hàng thành công (KHÔNG CÓ LINK)
function showCartSuccessModal(message) {
    createModal(message, null, null);
}

// 2. Trường hợp: Yêu cầu đăng nhập (CÓ LINK)
function showNotSignedInModal(message) {
    createModal(message, "/web/view/user/SignIn.php", "Đăng nhập ngay");
}
</script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Footer.php"; ?>
</body>
</html>