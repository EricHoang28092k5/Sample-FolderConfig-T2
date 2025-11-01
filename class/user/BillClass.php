<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
class BillClass extends DataBaseCLass{
    protected function findUserId($email){
        $conn = $this->connect();
        $sql = "SELECT id_nguoidung FROM nguoidung where email = '$email'";
        
        $result = $conn->query($sql);
        
        if(!$result){
            die("Lỗi truy vấn SQL." . $conn->error);
        } 
        
        if($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            return $row['id_nguoidung'];
        }
    }
    
    protected function findAllBill($IdNguoiDung) {
        $conn = $this->connect();
        $sql = "SELECT * FROM hoadon WHERE IdNguoiDung = $IdNguoiDung ORDER BY NgayDatHang DESC";
        
        $result = $conn->query($sql);
        
        if(!$result){
            die("Lỗi truy vấn SQL." . $conn->error);
        }

        $bills = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bills[] = $row;
            }
        }

        return $bills;
    }
    
    protected function getBillDetails($maHoaDon) {
            $conn = $this->connect();
            $sql = "SELECT c.*, s.TenSP, s.HinhAnh, s.MaSP FROM chitiethoadon c 
                    JOIN sanpham s ON c.MaSP = s.MaSP
                    WHERE c.IdHoaDon = $maHoaDon";
            $result = $conn->query($sql);

            if(!$result){
                die("Lỗi truy vấn SQL." . $conn->error);
            }

            $details = [];
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $details[] = $row;
                }
            }
            return $details;
    }

    protected function getBillSummary($maHoaDon) {
        $conn = $this->connect();
        
        $sql = "SELECT PhuongThucTT, TrangThai, TongTien, NgayDatHang 
                FROM hoadon 
                WHERE IdHoaDon = $maHoaDon";
        
        $result = $conn->query($sql);
        
        if(!$result){
            die("Lỗi truy vấn SQL: " . $conn->error);
        } 
        
        if($result && $result->num_rows > 0){
            return $result->fetch_assoc();
        }
        
        return null;
    }     
}
?>