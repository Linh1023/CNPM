<?php

use PHPUnit\Framework\TestCase;


# không test CRUD được vì không thấy có cách để lấy ID item vừa thêm (?)
final class ImportTest extends TestCase
{
    # test Date (for test items, som hon date cua tat ca cac item khac)
    private $leftDate = "2011-11-01";
    private $rightDate = "2011-11-11";
    # internal DAO instance
    private $import = new DAOPhieuNhap();
    public function TestViewOrderByIDAsc()
    {
        $items = $this->import->getListFollow();
        $this->assertNotNull($items);
        $this->assertNotEmpty($items);
        $ids = array_column($items, "MaPhieu");
        $this->assertEquals(sort($ids), $ids);
    }
    public function TestFilterByDateCorrect()
    {
        $items = $this->import->LocTheoKhoangTG($this->leftDate, $this->rightDate);
        $this->assertNotNull($items);
        $this->assertNotEmpty($items);
        $dates = array_column($items, "NgayTaoPN");
        $this->assertEquals("2011-11-01", min($dates));
        $this->assertEquals("2011-11-11", max($dates));
    }
    public function TestFilterByDateIncorrect()
    {
        $items = $this->import->LocTheoKhoangTG($this->rightDate, $this->leftDate);
        $this->assertNotNull($items);
        # khi nhap nguoc ngay thi ko the tim dc item nao ca nhung cung khong co loi
        $this->assertEmpty($items);
    }
}
