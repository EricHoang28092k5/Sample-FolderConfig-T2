<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class SearchProducts extends DataBaseClass {
    public function searchProducts($search = '', $maLoaiSP = 0, $min_price = 0, $max_price = 500000) {
        $conn = $this->connect();
        $sql = "SELECT * FROM sanpham WHERE 1";

        if (!empty($search)) {
            $search = $conn->real_escape_string($search);
            $sql .= " AND TenSP REGEXP '[[:<:]]" . $conn->real_escape_string($search) . "[[:>:]]'";
        }

        if ($maLoaiSP != 0) {
            $maLoaiSP = (int)$maLoaiSP;
            $sql .= " AND MaLoaiSP = $maLoaiSP";
        }

        $min_price = (int)$min_price;
        $max_price = (int)$max_price;
        $sql .= " AND DonGia BETWEEN $min_price AND $max_price";

        $result = $conn->query($sql);
        $data = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        return $data;
    }
}
?>
