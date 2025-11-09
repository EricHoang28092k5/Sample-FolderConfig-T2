<?php
        $tenNguoiDung = $_SESSION['tenNguoiDung'];
        $tenDangNhap = $_SESSION['tenDangNhap']; 
        $email = $_SESSION['email']; 
        $password = $_SESSION['password'];
        $sdt = $_SESSION['sdt'];
        $diaChi = $_SESSION['diaChi'];
        $quan_huyen = $_SESSION['quan_huyen'];
        $phuong_xa = $_SESSION['phuong_xa'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="view/user/css/Info.css"/>
    <link
      rel="shortcut icon"
      href="view/img/DMTD-Food-Logo.jpg"
      type="image/x-icon"
    />    
    <title>DMTD FOOD</title>
</head>
<body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Header.php"; ?>
<div class="container" style="max-width: 800px; margin: 40px auto; padding: 30px; box-shadow: 0 3px 15px rgba(0,0,0,0.1); border-radius: 10px; background-color: #fff;">
    <h2 style="text-align: center; color: #2c3e50; margin-bottom: 30px; font-size: 24px; font-weight: 600; position: relative; padding-bottom: 15px;">THÔNG TIN CÁ NHÂN</h2>
    
    <table class="info-table">
        <tr>
            <th>Họ và tên</th>
            <td><?php echo $tenNguoiDung; ?></td>
        </tr>
        <tr>
            <th>Tên đăng nhập</th>
            <td><?php echo $tenDangNhap; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $email; ?></td>
        </tr>
        <tr>
            <th>Số điện thoại</th>
            <td><?php echo $sdt; ?></td>
        </tr>
        <tr>
            <th>Địa chỉ</th>
            <td><?php echo $diaChi; ?></td>
        </tr>
        <tr>
            <th>Quận/Huyện</th>
            <td><?php echo $quan_huyen; ?></td>
        </tr>
        <tr>
            <th>Phường/Xã</th>
            <td><?php echo $phuong_xa; ?></td>
        </tr>
    </table>
    
    <div style="text-align: center;">
        <a href="/web/index.php?act=home" class="btn-back">Quay lại trang chủ</a>
    </div>
</div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Footer.php"; ?>
</body>
</html>
