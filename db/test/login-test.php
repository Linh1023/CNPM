<?php

use PHPUnit\Framework\TestCase;

final class LoginTest extends TestCase
{
    # test account
    public $account_id = 900001;
    # fake _POST and _SESSION
    public $_POST = array();
    public $_SESSION = array();
    # không thấy có hàm check username từ DAO
    # không thấy có class DTO chứa các trường dữ liệu của tài khoản
    # thấy có check đăng nhập ở file login_submit.php
    # code check không nằm trong class cũng không nằm trong hàm nào cả
    # các đối số được lấy từ $_POST
    # kết quả đăng nhập chỉ thấy có sự thay đổi $this->_SESSION["message"] = "Username không tồn tại!"
    # kết quả đăng nhập KHÔNG THÀNH CÔNG
    public function TestLoginIncorrectUsernameIncorrectPassword()
    {
        $this->_POST['username'] = "_test_username0_false";
        $this->_POST['password'] = "_test_password0_false";
        $this->_SESSION["message"] = "";
        require '../../account/login_submit.php';
        $this->assertEquals("Username không tồn tại!", $this->_SESSION["message"]);
    }
    # không thấy có hàm check username từ DAO
    # không thấy có class DTO chứa các trường dữ liệu của tài khoản
    # thấy có check đăng nhập ở file login_submit.php
    # code check không nằm trong class cũng không nằm trong hàm nào cả
    # các đối số được lấy từ $_POST
    # kết quả đăng nhập chỉ thấy có sự thay đổi $this->_SESSION["message"] = "Username không tồn tại!"
    # kết quả đăng nhập KHÔNG THÀNH CÔNG
    public function TestLoginIncorrectUsernameCorrectPassword()
    {
        $this->_POST['username'] = "_test_username0_false";
        $this->_POST['password'] = "_test_password0_true";
        $this->_SESSION["message"] = "";
        require '../../account/login_submit.php';
        $this->assertEquals("Username không tồn tại!", $this->_SESSION["message"]);
    }
    # không thấy có hàm check username VÀ password từ DAO
    # không thấy có class DTO chứa các trường dữ liệu của tài khoản
    # thấy có check đăng nhập ở file login_submit.php
    # code check không nằm trong class cũng không nằm trong hàm nào cả
    # các đối số được lấy từ $_POST
    # kết quả đăng nhập chỉ thấy có sự thay đổi $this->_SESSION["message"] = "Mật khẩu không đúng. Vui lòng nhập lại!"
    # kết quả đăng nhập KHÔNG THÀNH CÔNG
    public function TestLoginCorrecttUsernameIncorrectPassword()
    {
        $this->_POST['username'] = "_test_username0_true";
        $this->_POST['password'] = "_test_password0_false";
        $this->_SESSION["message"] = "";
        require '../../account/login_submit.php';
        $this->assertEquals("Mật khẩu không đúng. Vui lòng nhập lại!", $this->_SESSION["message"]);
    }
    # không thấy có hàm check username VÀ password từ DAO
    # không thấy có class DTO chứa các trường dữ liệu của tài khoản
    # thấy có check đăng nhập ở file login_submit.php
    # code check không nằm trong class cũng không nằm trong hàm nào cả
    # các đối số được lấy từ $_POST
    # kết quả đăng nhập có sự thay đổi $this->_SESSION['MaTaiKhoan']
    # kết quả đăng nhập THÀNH CÔNG
    public function TestLoginCorrectUsernameCorrectPassword()
    {
        $this->_POST['username'] = "_test_username0_true";
        $this->_POST['password'] = "_test_password0_true";
        $this->_SESSION["message"] = "";
        require '../../account/login_submit.php';
        # test account id
        $this->assertEquals($this->account_id, $this->_SESSION["MaTaiKhoan"]);
    }
}
