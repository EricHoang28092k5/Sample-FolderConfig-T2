<?php
session_start();
if(isset($_POST['addcart'])){
    $maSP = $_POST['id'];
    $tenSP = $_POST['tensp'];
    $gia = $_POST['gia'];
    $hinh = $_POST['hinh'];
    $soluong = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

    require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/CartContr.php";
    $cart = new CartContr();
    $cart->handleAddToCart($maSP, $tenSP, $gia, $hinh, $soluong);
    
}
?>