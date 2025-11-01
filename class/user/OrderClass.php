<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
class OrderClass extends DataBaseCLass{

    protected function findIdUser($email){
        $conn = $this->connect();
        $sql = "SELECT id_nguoidung FROM nguoidung where email = '$email'";
        
        $result = $conn->query($sql);
        
        if(!$result){
            die("Lỗi truy vấn SQL " . $conn->error);
        }

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $idNguoiDung = $row['id_nguoidung'];
            return $row['id_nguoidung'];
        }

        return 0;
    }

    protected function findIdDetail($email, $sdt){
        $conn = $this->connect();
        $sql = "SELECT IdHoaDon FROM hoadon 
                WHERE email = '$email' AND sdt = '$sdt' 
                ORDER BY NgayDatHang DESC LIMIT 1";
        $result = $conn->query($sql);
        
        if(!$result){
            die("Lỗi truy vấn SQL " . $conn->error);
        }

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $idHoaDon = $row['IdHoaDon'];
            return $idHoaDon;
        }

        return 0;
    }

    protected function addBill($idNguoiDung,$tenNguoiDung,$email,$sdt,$diaChi,$quan_huyen,$phuong_xa,$pttt,$tongTien){
        $conn = $this->connect();
        $sql = "INSERT INTO hoadon(IdNguoiDung,HoTen,email,sdt,DiaChi,quan_huyen,phuong_xa,NgayDatHang,TongTien,PhuongThucTT)
        VALUE('$idNguoiDung','$tenNguoiDung','$email','$sdt','$diaChi','$quan_huyen','$phuong_xa',NOW(),'$tongTien','$pttt')";

        
        $success = $conn->query($sql);
        
        if(!$success){
            die("Lỗi truy vấn SQL " . $conn->error);
        }        
    }

    protected function updateSellProduct($maSP, $soluong){
        $conn = $this->connect();
        $sql = "UPDATE sanpham SET SoLuongBan = SoLuongBan + $soluong WHERE MaSP = $maSP";
        
        $success = $conn->query($sql);
        if(!$success){
            die("Lỗi truy vấn SQL " . $conn->error);
        }           
    }

    protected function addDetailBill($idHoaDon,$giohang){
        $conn = $this->connect();

        foreach($giohang as $item){

            $MaSP = $item['maSP'];
            $DonGia = $item['gia'];
            $SoLuong = $item['soluong'];

            $sql = "INSERT INTO chitiethoadon(IdHoaDon,MaSP,SoLuong,DonGia)
            VALUE('$idHoaDon','$MaSP','$SoLuong','$DonGia')";

            $success = $conn->query($sql);
     
            if(!$success){
                die("Lỗi truy vấn SQL " . $conn->error);
            }
            
            $this->updateSellProduct($MaSP,$SoLuong);
        }
    }
}    
?>