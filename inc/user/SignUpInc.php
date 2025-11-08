<?php
if(isset($_POST['signUp'])){
    $tenNguoiDung = $_POST['tenNguoiDung'];
    $tenDangNhap = $_POST['tenDangNhap'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sdt = $_POST['sdt'];
    $diaChi = $_POST['diaChi'];
    $quan_huyen= $_POST['quan_huyen'];
    $phuong_xa = $_POST['phuong_xa'];

    require_once $_SERVER['DOCUMENT_ROOT'] . '/web/controller/user/SignUpContr.php';

    $signUp = new SignUpContr($tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa);
    $signUp->signUpUser();
    header("Location: /web/view/user/SignUp.php?none");
  }   
?>