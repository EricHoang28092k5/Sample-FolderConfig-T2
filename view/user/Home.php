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
    <?php 
    include_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Header.php"; 
    ?>

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
                        <form action="index.php?act=cart" method="post">
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
    include_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Footer.php"; 
    ?>
</body>
</html>