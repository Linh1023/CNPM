<?php
class DAOSoSize{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'ql_cuahanggiay';

    private $conn;

    public function __construct(){
        $this->connect();
    }

    public function connect(){
        if(!$this->conn){
            $this->conn=mysqli_connect($this->host,$this->username,$this->password,$this->database);
        }
    }

    public function disConnect() {
        if($this->conn){
            mysqli_close($this->conn);
        }
    }


    public function getList($MaSP) {
        $sql = "SELECT * FROM sosize Where MaSP='".$MaSP."'";
        $data=null;
        if($result = mysqli_query($this->conn,$sql)){
            while($row=mysqli_fetch_array($result)){
                    $data[] = $row;
            }
            mysqli_free_result($result);
        }
        return $data;
    }
    public function hasSize($MaSP) {
        $sql = "SELECT COUNT(*) FROM sosize WHERE MaSP='" . $MaSP . "'";
        $result = mysqli_query($this->conn, $sql);
        if ($result) {
            $count = mysqli_fetch_row($result)[0]; // Lấy giá trị đếm từ kết quả
            if ($count == 0) {
                return false;
            }
        }
        
        return true;
    }
    public function insertSozise($MaSP,$Size,$SoLuong,$GiaBan){
        $sql = "INSERT INTO `sosize` (`MaSP`, `SoLuong`, `Size`, `GiaBan`) VALUES ('".$MaSP."','".$SoLuong."','".$Size."','".$GiaBan."')";
        if(mysqli_query($this->conn,$sql)){
            return true;
        }
        return false;
    }

    public function deleteSozise($MaSP,$Size){
        $sql = "DELETE FROM sosize WHERE MaSP = '".$MaSP."'AND Size ='".$Size."'";
        if(mysqli_query($this->conn,$sql)){
            return true;
        }
        return false;
    }
    public function editSozise($MaSP,$Size,$SoLuong=0,$GiaBan=0){
        $sql = "UPDATE `sosize` SET `SoLuong` = '".$SoLuong."' , `GiaBan` = '".$GiaBan."' WHERE `MaSP` = '".$MaSP."' AND `Size` = '".$Size."'";
        if(mysqli_query($this->conn,$sql)){
            return true;
        }
        return false;
    }
}
?>