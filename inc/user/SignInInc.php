<?php
if(isset($_POST['signIn'])){
    $tenDangNhap = $_POST['tenDangNhap'];
    $password = $_POST['password'];

    require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/SignInContr.php";

    $signIn = new SignInContr($tenDangNhap,$password);
    $signIn->signInUser();
}
?>