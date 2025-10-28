<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class ProductClass extends DataBaseClass {

    protected function getAllProducts(){
        $conn = $this->connect();
        $sql = "SELECT * FROM sanpham ORDER BY MaSP DESC";
        return $conn->query($sql);
    }

    public function getProductsByPage($keyword, $maLoaiSP, $minPrice, $maxPrice, $limit, $offset) {
        $conn = $this->connect();

        // Tạo câu SQL cơ bản
        $sql = "SELECT * FROM sanpham WHERE DonGia BETWEEN $minPrice AND $maxPrice";

        if (!empty($keyword)) {
            $keyword = $conn->real_escape_string($keyword);
            $sql .= " AND TenSP LIKE '%$keyword%'";
        }
        if (!empty($maLoaiSP)) {
            $maLoaiSP = (int)$maLoaiSP;
            $sql .= " AND MaLoaiSP = $maLoaiSP";
        }

        $sql .= " LIMIT $offset, $limit";

        $result = $conn->query($sql);

        $products = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function countProducts($keyword, $maLoaiSP, $minPrice, $maxPrice) {
        $conn = $this->connect();
        $sql = "SELECT COUNT(*) AS total FROM sanpham WHERE DonGia BETWEEN $minPrice AND $maxPrice";

        if (!empty($keyword)) {
            $keyword = $conn->real_escape_string($keyword);
            $sql .= " AND TenSP LIKE '%$keyword%'";
        }
        if (!empty($maLoaiSP)) {
            $maLoaiSP = (int)$maLoaiSP;
            $sql .= " AND MaLoaiSP = $maLoaiSP";
        }

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>
