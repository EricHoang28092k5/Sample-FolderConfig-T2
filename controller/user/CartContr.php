<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/user/CartClass.php";

class CartContr extends CartClass{
    private $maSP;
    private $tenSP;
    private $gia;
    private $hinh;
    private $soluong;

    public function __construct(){
        parent::__construct();
    }

    public function handleAddToCart($maSP, $tenSP, $gia, $hinh, $soluong){
        if(!isset($_SESSION['tenDangNhap'])){
            header("Location: /web/index.php?act=notSignIn");
            exit();
        }else{
            $this->addToCart($maSP, $tenSP, $gia, $hinh, $soluong);
            header("Location: /web/index.php?act=addToCartSuccess");
            exit();
        }
    }

    public function handleViewCart(){
        return $_SESSION['giohang'];
    }
    
    public function handleDeleteItem($id) {
        $this->deleteItem($id);
    }

    public function getCleanCartItems(){    
    $cleanCart = [];

    foreach ($_SESSION['giohang'] as $maSP => $product) {

        $status = $this->getStatusProduct($maSP); 

        if ($status !== 0) {
            // sản phẩm không bị ẩn => lưu vào giỏ hàng
            $cleanCart[$maSP] = $product;
        }
    }
    $_SESSION['giohang'] = $cleanCart;
    
    return $cleanCart;        
    }

    public function calculatorCart(){
        $total = 0;
        if(!empty($_SESSION['giohang'])){
            foreach($_SESSION['giohang'] as $product){
                $total = $total + $product['gia'] * $product['soluong'];
            }
        }
        return $total;                
    }


}
?>