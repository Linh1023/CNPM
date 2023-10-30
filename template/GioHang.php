<?php
include_once('./db/DAOGioHang.php');
include('./db/DAOSP.php');
$db = new DAOSP();
$db->connect();
$dgh = new DAOGioHang();
$dgh->connect();
$list = null;
$MaTaiKhoan = null;

function TinhTienGiam($TiLegiam, $GiaBan)
{
    return $GiaBan - $GiaBan * $TiLegiam / 100;
}


if (isset($_SESSION['MaTaiKhoan'])) {
    $MaTaiKhoan = $_SESSION['MaTaiKhoan'];
    $list = $dgh->getListGioHang($MaTaiKhoan); // lấy các thông tin cần thiết để hiển thị lên bảng giỏ hàng
    //update giá bán theo khuyến mãi
    if($list != null){
        foreach ($list as $key => $value) {
            $TiLegiam = $db->getTiLeGiam($value["MaSP"]);
            $list[$key]["GiaBan"] = TinhTienGiam($TiLegiam, $value["GiaBan"]);
        }
    }
}


if (isset($_POST['update-click'])) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['ID'] == $id) {
                $_SESSION['cart'][$key]['SL'] = $quantity;
            }
        }
    }
    echo ' <script>window.location="GioHang.php";</script>';
}


if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'remove') {
        foreach ($list as $key => $value) {
            if ($value['MaSP'] == $_GET['MaSP']) {
                $dgh->deleteSP($MaTaiKhoan,$value['MaSP']);
                unset($list[$key]);
                echo ' <script>window.location="GioHang.php";</script>';
            }
        }
    }
}

if (isset($_POST['add_to_cart'])) {
    $MaSP = $_POST['MaSP'];
    $Size = $_POST['Size'];
    if ($dgh->addSP($MaTaiKhoan, $MaSP, 1, $Size)) {
        $data  = $db->getThongTinSanPham($MaSP,$Size);
        $data["SoLuong"] = 1;
        $TiLegiam = $db->getTiLeGiam($MaSP);
        $data["GiaBan"] = TinhTienGiam($TiLegiam,$data["GiaBan"]);
        array_push($list,$data);
    }
}
?>



<div id="gio_hang_container">
    <form method="POST" action="">
        <div id="thong_tin">
            <h1>Giỏ hàng</h1>
            <div id="cart_form">
                <form>
                    <table id="don_hang">
                        <tbody>
                            <tr>
                                <th>&ensp;&ensp;&ensp;</th>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th>&ensp; </th>
                            </tr>
                            <?php
                            if ($list != null) {
                                foreach ($list as $key => $value) {
                            ?>
                                    <tr>
                                        <td><a href="#"><img src="./img/products/<?php echo $value['AnhChinh'] ?>"></a></td>
                                        <td><a href="#">
                                                <strong><?php echo $value['Ten'] ?></strong>
                                                <span class="variant_title">Size: <?php echo $value['Size'] ?></span>
                                            </a></td>
                                        <td>
                                            <?php echo number_format($value['GiaBan'], 0, ",", ".") . "đ" ?>
                                        </td>
                                        <td style="padding: 20px 5px;">
                                            <input type="number" value="<?php echo $value['SoLuong'] ?>" min="1" max="<?php echo $value['SLTonKho'] ?>" class="sl" name="quantity[<?= $value['MaSP'] ?>]">
                                        </td>
                                        <td>
                                            <?php echo number_format($value['GiaBan'] * $value['SoLuong'], 0, ",", ".") . "đ" ?>
                                        </td>
                                        <td>
                                            <a href="GioHang.php?action=remove&MaSP=<?php echo $value['MaSP'] ?>">
                                                <button type="button" class="delete"><i class="ti-trash trash"></i></button>
                                        </td>
                                    </tr>

                            <?php }
                            }
                            ?>
                        </tbody>

                    </table>
                </form>
            </div>

            <div class="clearfix">
                <a href="index.php">mua tiếp</a>
                <input type="submit" name="update-click" id="update-click" value="Cập nhật giỏ hàng">
            </div>
        </div>
    </form>
    <div id="thanh_toan">
        <h2>Đơn hàng</h2>
        <div id="thanh_toan_container">
            <h2>
                <label>Tổng tiền</label>
                <label class="tien"><?php
                                    $TongTien = 0;
                                    if ($list != null) {
                                        foreach ($list as $value) {
                                            $TongTien += $value['SoLuong'] * $value['GiaBan'];
                                        }
                                    }
                                    echo number_format($TongTien, 0, ",", ".") . "đ";
                                    ?></label>
            </h2>
            <?php
            if ($list != null) {
            ?>
                <a href="./template/XuLyThanhToan.php">THANH TOÁN</a>
            <?php
            } else {

            ?>
                <a href="index.php">Tiếp tục mua hàng</a>
            <?php
            }
            ?>
        </div>
    </div>
</div>