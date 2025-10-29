<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/user/ProductClass.php"; 

class ProductContr extends ProductClass {

    public function showAllProducts(){
        $result = $this->getAllProducts();

        if($result && $result->num_rows > 0){
            $products = [];
            while($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        } else {
            echo "Truy vấn SQL thất bại";
            exit();
        }

        return $products;
    }

    public function getProductsByPage($keyword, $maLoaiSP, $minPrice, $maxPrice, $limit, $offset) {
        return parent::getProductsByPage($keyword, $maLoaiSP, $minPrice, $maxPrice, $limit, $offset);
    }

    public function countProducts($keyword, $maLoaiSP, $minPrice, $maxPrice) {
        return parent::countProducts($keyword, $maLoaiSP, $minPrice, $maxPrice);
    }

    public function getProductByID($id){
        $conn = $this->connect();
        $id= intval($id);
        $sql="SELECT * FROM sanpham WHERE MaSP= $id";
        $result= mysqli_query($conn,$sql);
        if($result && mysqli_num_rows($result)>0){
            return mysqli_fetch_assoc($result);
        }
        return null;
    }
}
?>
