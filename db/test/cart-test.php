<?php

use PHPUnit\Framework\TestCase;

final class CartTest extends TestCase
{
    # test account, test item
    public $account_id = 900001;
    public $item_id = 900001;
    # test item quantity
    public $item_quantity = 9;
    # test item available size
    public $item_sizer = 32;
    # internal DAO instance
    private $cart = new DAOGioHang();
    # cố gắng xóa sạch giỏ hàng trước khi test tránh fail case do interrupt test trước khi clean up
    public function TestEmptyCart()
    {
        $this->cart->deleteAll($this->account_id);
        $items = $this->cart->getListGioHang($this->account_id);
        # không có sp nào trong giỏ
        $this->assertIsArray($items);
        $this->assertEmpty($items);
    }
    public function TestAddItemIncorrectAccountID()
    {
        $this->TestEmptyCart();
        $this->assertFalse($this->cart->addSP(0, $this->item_id, $this->item_quantity, $this->item_sizer));
    }
    public function TestAddItemIncorrectItemID()
    {
        $this->TestEmptyCart();
        $this->assertFalse($this->cart->addSP($this->account_id, 0, $this->item_quantity, $this->item_sizer));
    }
    public function TestAddItemIncorrectQuantity()
    {
        $this->TestEmptyCart();
        $this->assertFalse($this->cart->addSP($this->account_id, $this->item_id, 0, $this->item_sizer));
    }
    public function TestAddItemIncorrectSizer()
    {
        $this->TestEmptyCart();
        $this->assertFalse($this->cart->addSP($this->account_id, $this->item_id, $this->item_quantity, 0));
    }
    # private de khong include vao test
    private function PrepAddItem()
    {
        $this->TestEmptyCart();
        $this->assertTrue($this->cart->addSP($this->account_id, $this->item_id, $this->item_quantity, $this->item_sizer));
        # check sp trong gio, sp dau tien vi chi them 1
        $items = $this->cart->getListGioHang($this->account_id);
        $this->assertNotNull($items);
        $this->assertCount(1, $items);
        $item = $items[0];
        $this->assertArrayHasKey("MaSP", $item);
        $this->assertEquals($this->item_id, $item["MaSP"]);
        $this->assertEquals($this->item_quantity, $item["SoLuong"]);
        $this->assertEquals($this->item_sizer, $item["sosize"]);
    }
    public function TestUpdateItem()
    {
        $this->TestEmptyCart();
        $this->PrepAddItem();
        # sua sp
        $this->assertTrue($this->cart->updateGiohang($this->account_id, $this->item_id, 1));
        # check sp trong gio, sp dau tien vi chi them 1
        $items = $this->cart->getListGioHang($this->account_id);
        $this->assertNotNull($items);
        $this->assertCount(1, $items);
        $item = $items[0];
        $this->assertArrayHasKey("MaSP", $item);
        $this->assertEquals($this->item_id, $item["MaSP"]);
        $this->assertEquals(1, $item["SoLuong"]);
        $this->assertEquals($this->item_sizer, $item["sosize"]);
    }
    public function TestDeleteItem()
    {
        $this->TestEmptyCart();
        $this->PrepAddItem();
        $this->assertTrue($this->cart->deleteSP($this->account_id, $this->item_id));
        # vi chi co 1 sp nen gio hang k con gi luon
        $items = $this->cart->getListGioHang($this->account_id);
        $this->assertIsArray($items);
        $this->assertEmpty($items);
    }
}
