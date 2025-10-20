<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/SignInContr.php";

$isLoggedIn = isset($_SESSION['tenDangNhap']);

if($isLoggedIn){
    $vaiTro = $_SESSION['role'];
    if($vaiTro == "admin"){
        session_destroy();
        header("location: /web/view/admin/index.php");
    }else{
        $tenNguoiDung = $_SESSION['tenNguoiDung'];
        $tenDangNhap = $_SESSION['tenDangNhap']; 
        $email = $_SESSION['email']; 
        $password = $_SESSION['password'];
        $sdt = $_SESSION['sdt'];
        $diaChi = $_SESSION['diaChi'];
        $quan_huyen = $_SESSION['quan_huyen'];
        $phuong_xa = $_SESSION['phuong_xa'];

        $checkStatus = new SignInContr($tenDangNhap,$email);
        $trangThai = $checkStatus->kiemTraQuyenTruyCap();

        if($trangThai == 2){
            header("Location:/web/view/user/LogOut.php");
            exit();
        }
    }
}

if(!isset($_SESSION['giohang'])){
    $_SESSION['giohang']=[];
}

if(isset($_GET['act'])){
    echo 'XIN CHAO';
    switch($_GET['act']){
        case 'cart':

    }
}else{
    require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Home.php";
}
?>