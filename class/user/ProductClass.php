<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
class ProductClass extends DataBaseClass{

    protected function getAllProducts(){
        $conn = $this->connect();
        $sql = "SELECT * FROM sanpham ORDER BY MaSP DESC";
        return $conn->query($sql);
    }
}
?>