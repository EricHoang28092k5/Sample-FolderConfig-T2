<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/SignInContr.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/ProductContr.php";

// Kiểm tra đăng nhập
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

$productController = new ProductContr();
$productList = $productController->showAllProducts();


$productController = new ProductContr();

$item_perpage = !empty($_GET['per_page']) ? intval($_GET['per_page']) : 8;
$current_page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($current_page - 1) * $item_perpage;

$search = $_GET['search'] ?? '';
$maLoaiSP = $_GET['MaLoaiSP'] ?? 0;
$min_price = $_GET['min_price'] ?? 0;
$max_price = $_GET['max_price'] ?? 100000000;

$totalProducts = $productController->countProducts($search, $maLoaiSP, $min_price, $max_price);
$totalPages = ceil($totalProducts / $item_perpage);

$productList = $productController->getProductsByPage($search, $maLoaiSP, $min_price, $max_price, $item_perpage, $offset);

if(isset($_GET['act'])){
    switch($_GET['act']){
        case 'home':
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Home.php";
            break;
                    
        case 'notSignIn':
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Home.php";
            break;
    
        case 'addToCartSuccess':
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Home.php";
            break;

        case 'viewCart':
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Cart.php";
            break;

        case 'checkOrder':
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/CheckOrder.php";
            break;

        case "payMentSuccess":
            unset($_SESSION['giohang']);
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/OrderSuccess.php";
            break;
        
        case "viewBill":
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Bill.php";
            break;
    }
}else{
    require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Home.php";
}
?>
