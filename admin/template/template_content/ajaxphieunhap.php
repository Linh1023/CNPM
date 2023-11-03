<?php 
include("../../../db/DAOPhieuNhap.php");
include("../../../db/DAOChiTietPhieuNhap.php");
if (isset($_POST['flag'])) {
    $daoPhieuNhap = new DAOPhieuNhap();
    $listPhieuNhap = $daoPhieuNhap->getListFollow();
    $rows = '';
    echo '<thead>';
    echo '<th>Mã phiếu</th>';
    echo '<th>Hãng</th>';
    echo '<th>Tổng đơn</th>';
    echo '<th>Nhân viên</th>';
    echo '<th>Ngày tạo</th>';
    echo '<th>Trạng thái</th>';
    echo '<th>Ghi chú</th>';
    echo '<th>Hành động</th>';
    echo '</thead>';
    
    foreach ($listPhieuNhap as $row) {
        $MaPhieu = rtrim ($row['MaPhieu']);
        $MaHang = rtrim($row['Ten']);
        $Tongdon = rtrim($row['TongDon']);
        $MaTaiKhoan = rtrim($row['TenNhanVien']);
        $NgayTao = rtrim($row['NgayTaoPN']);
        $GhiChu= rtrim($row['GhiChu']);
        $TrangThai = $row['TrangThaiPN'];
        
        if ($TrangThai == '1'){ // đã duyệt
            $TrangThai = rtrim('Đã duyệt');
            $css ="style = 'background-color:chartreuse'";
            $HanhDong = '<button type="button" class="btn" style="background-color:burlywood" onclick="xemChiTiet(this)"  >Xem chi tiết</button>';
        } else if ($TrangThai == '0') { // chờ duyệt
            $TrangThai = rtrim('Chờ duyệt');
            $css ="style = 'background-color:yellow'";
            $HanhDong = '<button type="button" class="btn" style="background-color:chartreuse" onclick="duyet(this)" >Duyệt</button> 
            <button type="button" class="btn" style="background-color:red" onclick="tuChoi(this)" >Từ chối</button> 
            <button type="button" class="btn" style="background-color:burlywood" onclick="xemChiTiet(this)"  >Xem chi tiết</button>
            ';
        } else if ($TrangThai == '2') { // từ chối
            $TrangThai = rtrim('Bị từ chối');
            $css ="style = 'background-color:red'";
            $HanhDong = ' <button type="button" class="btn" style="background-color:burlywood" onclick="xemChiTiet(this)"  >Xem chi tiết</button>
            <button type="button" class="btn" style="background-color:red" onclick="xoa(this)">Xóa</button>
            ';
        }

        $rows .= "<tr><td>$MaPhieu</td><td>$MaHang</td><td>$Tongdon</td><td>$MaTaiKhoan</td><td>$NgayTao</td><td $css >$TrangThai</td><td>$GhiChu</td><td>$HanhDong</td></tr>";
       
        }
       echo '<tbody>';
       echo $rows;       
       echo '</tbody>';
}

if (isset($_POST['maPNDuyet'])) {
    $maPN = $_POST['maPNDuyet'];
    $daoPhieuNhap = new DAOPhieuNhap();
    $daoPhieuNhap->updateTrangThaiPN (1, $maPN);

    // update lại số lượng trong sản phẩm

    echo $maPN;
}

if (isset($_POST['maPNTuChoi'])) {
    $maPN = $_POST['maPNTuChoi'];
    $daoPhieuNhap = new DAOPhieuNhap();
    $daoPhieuNhap->updateTrangThaiPN (2, $maPN);
    echo $maPN;
}

if (isset($_POST['maPNXoa'])) {
    $maPN = $_POST['maPNXoa'];
    $daoCTPN = new DAOChiTietPhieuNhap();
    $daoCTPN->deleteCTPN($maPN);
    $daoPhieuNhap = new DAOPhieuNhap();
    $daoPhieuNhap->deletePhieuNhap($maPN);
    echo $maPN;
}





// $daoPhieuNhap = new DAOPhieuNhap();
// $daoPhieuNhap->addPhieuNhap('2023-11-09', 220211, 'MH-002', 8, 1, 'Khong co');









?>