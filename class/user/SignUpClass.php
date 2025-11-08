<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
class SignUpClass extends DataBaseClass{
    
    protected function setUser($tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa)
    {
        $conn = $this->connect();
        
        $sql = "INSERT INTO nguoidung (tennguoidung, tenDangNhap, email, password, sdt, diaChi, quan_huyen, phuong_xa) 
        VALUES ('$tenNguoiDung', '$tenDangNhap', '$email', '$password', '$sdt', '$diaChi', '$quan_huyen', '$phuong_xa')";

        $success = $conn->query($sql);
        
        if (!$success){
            die("Lỗi truy vấn SQL:".$conn->error);
        }
    }
    
    protected function checkUser($email, $tenDangNhap){
        $conn = $this->connect();
        
        $sql = "SELECT id_nguoidung FROM nguoidung WHERE email = '$email' OR tenDangNhap = '$tenDangNhap'";
        
        $result = $conn->query($sql);
        
        if (!$result){
            die("Lỗi truy vấn SQL: ". $conn->error);
        }

        $resultCheck;
        if($result->num_rows > 0){
            $resultCheck = false;
        }else{
            $resultCheck = true;
        }

        return $resultCheck;
    }    
}
?>