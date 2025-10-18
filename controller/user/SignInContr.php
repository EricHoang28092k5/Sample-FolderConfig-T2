<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/user/SignInClass.php"; 
class SignInContr extends SignInClass{
    private $tenDangNhap;
    private $password;

    public function __construct($tenDangNhap, $password){
        $this->tenDangNhap = $tenDangNhap;
        $this->password = $password;
    }

    public function signInUser(){
        $this->getUser($this->tenDangNhap, $this->password);
    }
}    
?>