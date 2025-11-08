<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/user/OrderClass.php";
class OrderContr extends OrderClass{
    private $tenNguoiDung;
    private $email;
    private $sdt;
    private $diaChi;
    private $quan_huyen;
    private $phuong_xa;
    private $pttt;
    private $tongTien;
  
    public function __construct($tenNguoiDung, $email, $sdt, $diaChi, $quan_huyen, $phuong_xa, $pttt, $tongTien) {
        $this->tenNguoiDung = $tenNguoiDung;
        $this->email = $email;
        $this->sdt = $sdt;
        $this->diaChi = $diaChi;
        $this->quan_huyen = $quan_huyen;
        $this->phuong_xa = $phuong_xa;
        $this->pttt = $pttt;
        $this->tongTien = $tongTien;
    }
    //Thực hiện việc thanh toán
    public function handlePayMent(){
        $this->handleAddBill();
        $this->handleAddDetailBill();
    }
    
    //thực hiện việc thêm hóa đơn vào DB
    public function handleAddBill(){
        $idNguoiDung = $this->findIdUser($this->email);
        $_SESSION['maNguoiDung'] = $idNguoiDung;
        $this->addBill($idNguoiDung, $this->tenNguoiDung, $this->email, $this->sdt, $this->diaChi, 
                       $this->quan_huyen, $this->phuong_xa, $this->pttt, $this->tongTien);
    }

    //thực hiện việc thêm chi tiết hóa đơn vào DB
    public function handleAddDetailBill(){
        $idHoaDon = $this->findIdDetail($this->email, $this->sdt);
        $_SESSION['maHoaDon'] = $idHoaDon;
        $this->addDetailBill($idHoaDon, $_SESSION['giohang']);
    }
}
?>