<?php
require_once dirname(__FILE__) . '/../classes/Calculation.php';

class CalculationTest extends PHPUnit_Framework_TestCase {

    /**
     * 指定なし
     * 全部無効
     */
    public function test() {
        $calculation = $this->getMock(Calculation::class);
        $result = $calculation->increment();
        $this->assertNull($result);
    }

    /**
     * 指定あり
     * 指定したメソッドだけ無効
     */
    public function test2() {
        $calculation = $this->getMock(Calculation::class, ['getTotal', 'setTotal']);
        $result = $calculation->increment();
        $this->assertEquals('2', $result);
    }

    /**
     * NULL
     * 全部無効化しない
     */
    public function test3() {
        $calculation = $this->getMock(Calculation::class, null);
        $result = $calculation->increment();
        $this->assertEquals('2', $result);

        $calculation->setTotal(10);
        $result = $calculation->getTotal();
        $this->assertEquals('10', $result);

    }

    /**
     * 指定なし
     * 全部無効
     */
    public function test4() {
        $calculation = $this->createMock(Calculation::class);
        $result = $calculation->increment();
        $this->assertNull($result);
    }

    /**
     * 指定あり
     * 指定したメソッドだけ無効
     * コンストラクタは呼ばれない
     */
    public function test5() {
        $calculation = $this->createPartialMock(Calculation::class, ['getTotal', 'setTotal']);
        $result = $calculation->increment();
        $this->assertEquals('1', $result);
    }

    /**
     * NULL
     * 全部無効化しない
     * コンストラクタは呼ばれない
     */
    public function test6() {
        $calculation = $this->createPartialMock(Calculation::class, []);
        $result = $calculation->increment();
        $this->assertEquals('1', $result);

        $calculation->setTotal(10);
        $result = $calculation->getTotal(10);
        $this->assertEquals(10, $result);
    }
    
    public function test7() {
        $calculation = $this->createMock(Calculation::class);
        $calculation->method('getTotal')->willReturn(3);

        $result = $calculation->getTotal();
        $this->assertEquals(3, $result);
    }
}
