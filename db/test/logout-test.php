<?php

use PHPUnit\Framework\TestCase;

include_once("login-test.php");
final class LogoutTest extends TestCase
{
    # kết quả chỉ thấy có sự thay đổi $_SESSION["message"] = "Đăng xuất Thành công"
    # session_unset, session_destroy khong co tac dung gi vi dang test with fake _POST va _SESSION
    # co dang xuat thanh cong hay khong thi cung $_SESSION["message"] = "Đăng xuất Thành công" (?)
    public function TestLogoutWhileLoggedIn()
    {
        # login truoc
        $loginTest = new LoginTest("logout-test");
        $loginTest->TestLoginCorrectUsernameCorrectPassword();
        $this->assertEquals($loginTest->account_id, $loginTest->_SESSION["MaTaiKhoan"]);
        # logout
        require '../../account/logout.php';
        $this->assertEquals("Đăng xuất Thành công", $loginTest->_SESSION["message"]);
    }
    public function TestLogout()
    {
        require '../../account/logout.php';
        $this->assertEquals("Đăng xuất Thành công", $loginTest->_SESSION["message"]);
    }
}
