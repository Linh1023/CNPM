<?php
include '../../db/dbconnect.php';
include("../../db/DAOSP.php");
$db = new DAOSP();
$db->connect();
if (isset($_GET['idsp'])) {
    $idsp = $_GET['idsp'];
    $sql = 'UPDATE sanpham SET TrangThai=0 where  MaSP = "' . $idsp . '"';
    $result = $conn->query($sql);
    if ($result)
        echo "<script>
        alert('Xóa Thành Công');
        window.location = '../index.php?id=sp'
        </script>";
    $conn->close();
    return;

} else {
    echo "<script>
    alert('Xóa không Thành Công');
    window.location = '../index.php?id=sp'
    </script>";
    $conn->close();
    return;
}
?>