<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/user/BillClass.php";
class BillContr extends BillClass{
    
    //Lấy chi tiết hóa đơn
    public function handleGetBillDetail($maHoaDon){
        return $this->getBillDetails($maHoaDon);
    }

    public function getUserId($email){
        return $this->findUserId($email);
    }

    // lấy tất cả hóa đơn ra
    public function getAllBill($IdNguoiDung){
        return $this->findAllBill($IdNguoiDung);
    }

    public function getBill($maHoaDon){
        return $this->findBill($maHoaDon);
    }
    public function getBillSummaryInfo($maHoaDon){
        return $this->getBillSummary($maHoaDon); 
    }
}
?>