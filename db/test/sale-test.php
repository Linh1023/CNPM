<?php

use PHPUnit\Framework\TestCase;

final class SaleTest extends TestCase
{
    # ma khuyen mai test
    private $saleCode = "_test_MAKMSGUCNPM";
    private $saleName = "SV SGU -20%";
    private $saleDesc = "Ma giam gia cho sv sgu 20% all sp khong bao gio het han.";
    private $saleOffBy = 20; # phan tram
    # id san pham test va gia test dc giam gia theo ma tren
    # test cai tinh toan gia o dau (?)
    private $products = array(array(900001, 2_000_000), array(900002, 500_000), array(900003, 1_500_000));
    # internal DAO instance
    private $saler = new DAOKhuyenMai();
    # cố gắng xóa ma trước khi test tránh fail case do interrupt test trước khi clean up
    public function PrepNoCode()
    {
        $this->saler->deleteKM($this->saleCode);
        $this->assertFalse($this->saler->hasKM($this->saleCode));
    }
    public function TestAddSaleIncorrectCode()
    {
        $this->PrepNoCode();
        $this->assertFalse($this->saler->insertKM("", $this->saleName, $this->saleDesc, $this->saleOffBy));
    }
    public function TestAddSaleNoName()
    {
        $this->PrepNoCode();
        $this->assertTrue($this->saler->insertKM($this->saleCode, "", $this->saleDesc, $this->saleOffBy));
    }
    public function TestAddSaleNoDesc()
    {
        $this->PrepNoCode();
        $this->assertTrue($this->saler->insertKM($this->saleCode, $this->saleName, "", $this->saleOffBy));
    }
    public function TestAddSaleOffTooLarge()
    {
        $this->PrepNoCode();
        $this->assertFalse($this->saler->insertKM($this->saleCode, $this->saleName,  $this->saleDesc, 101));
    }
    public function TestAddSaleOffTooLow()
    {
        $this->PrepNoCode();
        $this->assertFalse($this->saler->insertKM($this->saleCode, $this->saleName,  $this->saleDesc, 0));
    }
    # private de khong include vao test
    private function TestAddSale()
    {
        $this->PrepNoCode();
        $this->assertTrue($this->saler->insertKM($this->saleCode, $this->saleName, $this->saleDesc, $this->saleOffBy));
    }
    public function TestGetSaleName()
    {
        $this->PrepNoCode();
        $this->TestAddSale();
        $this->assertEquals($this->saleName, $this->saler->getTenTheoMa($this->saleCode));
    }
    // public function TestCodeIsInUse()
    // {
    //     $this->PrepNoCode();
    //     $this->TestAddSale();
    //     assertTrue($this->saler->hasSP($this->saleCode));
    // }
    public function TestEditSale()
    {
        $this->PrepNoCode();
        $this->TestAddSale();
        # sua sp
        $this->assertTrue($this->saler->updateKM($this->saleCode, $this->saleName, $this->saleDesc, 30));
        # check lai
        # khong thay co cach get thong tin Sale (?)
        $this->assertTrue($this->saler->hasKM($this->saleCode));
    }
    public function TestDeleteSale()
    {
        $this->PrepNoCode();
        $this->TestAddSale();
        # check lan 2 cho chac an
        $this->assertTrue($this->saler->hasKM($this->saleCode));
        # XOA
        $this->saler->deleteKM($this->saleCode);
        $this->assertFalse($this->saler->hasKM($this->saleCode));
    }
}
