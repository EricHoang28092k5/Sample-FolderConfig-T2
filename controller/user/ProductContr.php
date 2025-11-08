<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/user/ProductClass.php"; 

class ProductContr extends ProductClass{

    public function showAllProducts(){
        $result = $this->getAllProducts();

        if($result && $result->num_rows > 0){
            $products = [];
            while($row = $result->fetch_assoc())
                $products[] = $row;
        }else{
            echo "Truy vấn SQL thất bại";
            exit();
        }

        return $products;
    }
}
?>