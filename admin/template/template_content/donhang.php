<script>
    $(document).ready(function() {
        $(".XuLyDon").click(function() {
            MaDonHang = $(this).val();
            if (confirm(`Xử lý đơn hàng ${MaDonHang}?`)) {
                $.get("./template/template_content/xulyDonHang.php", {
                        MaDon: MaDonHang,
                        pq: "<?php echo $MaQuyen ?>",
                    },
                    function(data) {
                        $("#ThongBao").html(data);
                        setTimeout(function() {
                            $("#ThongBao").html("");
                        }, 5000);
                    });
            }
        });

        $(".HuyDon").click(function() {
            MaDonHang = $(this).val();
            if (confirm(`Hủy đơn hàng ${MaDonHang}?`)) {
                $.get("./template/template_content/huyDonHang.php", {
                        MaDon: MaDonHang,
                        pq: "<?php echo $MaQuyen ?>",
                    },
                    function(data) {
                        $("#ThongBao").html(data);
                    });
            }
        });
    });
</script>



<form action="" method="POST">
    <h2 id="title_dh">Danh sách đơn hàng</h2>




    <!-- Tạo thành chọn ngày lọc -->
    <h3 id="title_loc">Lọc đơn hàng theo ngày</h3>
    <label for="from" class="label_from">Từ :</label>
    <input type="date" name="from" id="from">
    <label for="to" class="to">Đến :</label>
    <input type="date" name="to" id="to">
    <input type="submit" name="Loc" id="Loc" value="Lọc">
    <input type="submit" name="Refresh" id="Refresh" value="Refresh">


    <!-- Chỗ để thông tin hàng bị thiếu -->
    <div id="ThongBao">

    </div>

    <table id="ds_donhang">
        <tr>
            <th>Mã đơn</th>
            <th>Mã tài khoản</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Tổng tiền</th>
            <th>Cập nhật trạng thái</th>
            <th style="width: 23%">Xem chi tiết</th>
        </tr>
        <?php
        if (isset($_POST['Loc']) == false) {
            include("../db/DAODonHang.php");
            $db = new DAODonHang();
            $db->connect();
            $data = $db->getList('donhang');
            $i = 0;
            if ($data == null) return;
            while ($i < count($data)) {


        ?>
                <tr>
                    <td><?php echo $data[$i][0] ?></td>
                    <td><?php echo $data[$i][1] ?></td>
                    <td><?php echo $data[$i][2] ?></td>
                    <td <?php
                        if ($data[$i][3] == 0) {
                            echo "style = 'background-color: #bdbd44; color: white;'";
                        } else if ($data[$i][3] == 2) {
                            echo "style = 'background-color: red; color: white;'";
                        }
                        ?>>
                        <?php
                        switch ($data[$i][3]) {
                            case 0:
                                echo 'Chưa xử lý';
                                break;
                            case 1:
                                echo 'Đã xử lý';
                                break;
                            case 2:
                                echo 'Đã bị hủy';
                                break;
                            default:
                                break;
                        }
                        ?></td>
                    <td><?php echo number_format($data[$i][4], 0, ',', '.') . "đ" ?></td>
                    <td>
                        <?php
                        if ($data[$i][3] == 0) {
                            echo '<button type="button" class="XuLyDon" value = "' . $data[$i][0] . '">Xử lý</button>
                                <button type="button" class="HuyDon" value = "' . $data[$i][0] . '">Hủy</button></td>';
                        }
                        ?>
                    </td>
                    <td><a href="./template/template_content/ChiTietDonHang.php?CT=<?php echo $data[$i][0] ?>&MaTK=<?php echo $data[$i][1] ?>&Date=<?php echo $data[$i][2] ?>&TT=<?php echo $data[$i][4] ?>">
                            <div>Xem chi tiết đơn hàng</div>
                        </a></td>

                </tr>
                <?php
                $i++;
            }
        } else {
            if (isset($_POST['from']) && $_POST['to']) {
                $from = $_POST['from'];
                $to = $_POST['to'];
                include('../db/DAODonHang.php');
                $db = new DAODonHang();
                $db->connect();
                $data = $db->Loc($from, $to);
                if ($data == false) {
                    return;
                }
                $i = 0;
                if ($data == null) {
                }
                while ($i < count($data)) {
                ?>
                    <tr>
                        <td><?php echo $data[$i][0] ?></td>
                        <td><?php echo $data[$i][1] ?></td>
                        <td><?php echo $data[$i][2] ?></td>
                        <td <?php
                            if ($data[$i][3] == 0) {
                                echo "style = 'background-color: #bdbd44; color: white;'";
                            } else if ($data[$i][3] == 2) {
                                echo "style = 'background-color: red; color: white;'";
                            }
                            ?>>
                            <?php
                            switch ($data[$i][3]) {
                                case 0:
                                    echo 'Chưa xử lý';
                                    break;
                                case 1:
                                    echo 'Đã xử lý';
                                    break;
                                case 2:
                                    echo 'Đã bị hủy';
                                    break;
                                default:
                                    break;
                            }
                            ?></td>
                        <td><?php echo number_format($data[$i][4], 0, ',', '.') . "đ" ?></td>
                        <td>
                            <?php
                            if ($data[$i][3] == 0) {
                                echo '<button type="button" class="XuLyDon" value = "' . $data[$i][0] . '">Xử lý</button>
                                <button type="button" class="HuyDon" value = "' . $data[$i][0] . '">Hủy</button></td>';
                            }
                            ?>
                        </td>
                        <td><a href="./template/template_content/ChiTietDonHang.php?CT=<?php echo $data[$i][0] ?>&MaTK=<?php echo $data[$i][1] ?>&Date=<?php echo $data[$i][2] ?>&TT=<?php echo $data[$i][4] ?>">
                                <div>Xem chi tiết đơn hàng</div>
                            </a></td>
                    </tr>
        <?php
                    $i++;
                }
            }
        }
        ?>

    </table>

    </from>