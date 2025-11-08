<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
class SignInClass extends DatabaseClass {

    protected function getUser($tenDangNhap, $password) {
        $conn = $this->connect();

        $sql = "SELECT * FROM nguoidung WHERE tenDangNhap = '$tenDangNhap' AND password = '$password' ";
        $stmt = $conn->query($sql);

        if (!$stmt) {
            die("Lỗi truy vấn SQL: ". $conn->error);
            exit();
        }

        // Không tìm thấy người dùng
        if ($stmt->num_rows === 0) {
            $stmt->free();
            header("Location: /web/view/user/SignIn.php?error=wrong-user-or-pass");
            exit();
        } else {
            $row = $stmt->fetch_assoc();

            // Kiểm tra trạng thái bị khóa
            if ($row['TrangThai'] == 2) {
                $stmt->free();
                header("Location: /web/view/user/SignIn.php?error=block-user");
                exit();
            }

            $stmt->free();
            // Bắt đầu session và lưu thông tin người dùng
            session_start();
            $_SESSION['role'] = $row['vaiTro'];
            $_SESSION['tenNguoiDung'] = $row['tenNguoiDung'];
            $_SESSION['tenDangNhap'] = $row['tenDangNhap'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['sdt'] = $row['sdt'];
            $_SESSION['diaChi'] = $row['diaChi'];
            $_SESSION['quan_huyen'] = $row['quan_huyen'];
            $_SESSION['phuong_xa'] = $row['phuong_xa'];

            // Chuyển hướng tùy vai trò
            if ($row['vaiTro'] === 'admin') {
                header("Location: /web/view/admin/index.php");
            } else {
                header("Location: /web/index.php");
            }
            exit();
        }

        $stmt->close();
    }

    protected function kiemTraTrangThaiTaiKhoan($tenDangNhap){
        $trangThai;
        $conn = $this->connect();
        $result = $conn->query("SELECT TrangThai FROM nguoidung WHERE tenDangNhap ='$tenDangNhap'");
        
        if($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            $trangThai = (int)$row["TrangThai"];
        }else{
            die("Lỗi truy vấn SQL:" . $conn->error);
            exit();
        }

        return $trangThai;
    }
}
?>
