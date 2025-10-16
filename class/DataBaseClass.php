<?php
class DataBaseClass{
    
    public function connect(){
        try{
            $username = "root";
            $pass = "";
            $host = "localhost";
            $dbname = "web";
            
            $conn = new mysqli($host, $username, $pass, $dbname);
            
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
            
            // Set charset to utf8
            $conn->set_charset("utf8");
            
            return $conn;
        }catch (Exception $e){
            print "Error: " . $e->getMessage(). "<br/>";
            die();
        }
    }
}
?>