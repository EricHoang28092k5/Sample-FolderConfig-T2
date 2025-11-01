<?php
session_start();
if(isset($_POST['thanhtoan'])){
    $tenNguoiDung = $_POST['tenNguoiDung'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $diaChi = $_POST['diaChi'];
    $quan_huyen = $_POST['quan_huyen'];
    $phuong_xa = $_POST['phuong_xa'];
    $pttt = $_POST['pttt'];
    $tongTien = $_POST['tongTien'];
    
    require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/OrderContr.php";

    $bill = new OrderContr($tenNguoiDung, $email, $sdt, $diaChi, $quan_huyen, $phuong_xa, $pttt, $tongTien);
    $bill->handlePayMent();
    
    $_SESSION['orderInfo'] = [
        'id' => $_SESSION['maHoaDon'],
        'date' => date("d/m/Y"),
        'tenNguoiDung' => $tenNguoiDung,
        'email' => $email,
        'sdt' => $sdt,
        "diaChi" => $diaChi,
        "quan_huyen" => $quan_huyen,
        "phuong_xa" => $phuong_xa,
        "pttt" => $pttt,
        "tongTien" => $tongTien,
        "order_success" => true,
        'order_item' => $_SESSION['giohang']
    ];
    unset($_SESSION['giohang']);
    header("Location:/web/index.php?act=payMentSuccess");
    exit();
}
?>