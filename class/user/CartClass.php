<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
class CartClass extends DataBaseClass{
    protected function __construct(){
        if(!isset($_SESSION['giohang'])){
            $_SESSION['giohang'] = [];
        }
    }

    protected function addToCart($maSP, $tenSP, $gia, $hinh, $soluong){
        if(!isset($_SESSION['giohang'][$maSP])){
            $_SESSION['giohang'][$maSP] = [
                'maSP' => $maSP,
                'tenSP' => $tenSP,
                'gia' => $gia,
                'hinh' => $hinh,
                'soluong' => $soluong
            ];            
        }else{
            $soluongnew = $soluong + $_SESSION['giohang'][$maSP]['soluong'];
            $_SESSION['giohang'][$maSP]['soluong'] = $soluongnew;
        }
    }
    
    protected function deleteItem($id) {
        if (isset($_SESSION['giohang'][$id])) {
            unset($_SESSION['giohang'][$id]);
        }
    }

    protected function getStatusProduct($maSP){
        $conn = $this->connect();
        $sql = "SELECT TrangThai FROM sanpham WHERE MaSP = $maSP ";
        
        $result = $conn->query($sql);
        if($result && $result->num_rows >0){
           $row =  $result->fetch_assoc();
           $trangThai = (int)$row['TrangThai'];
        }else{
            die("Lỗi SQL " . $conn->error);
        }

        return $trangThai;


    }
}
?>