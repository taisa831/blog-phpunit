<?php
require_once dirname(__FILE__) . '/../classes/Example.php';

/**
 * PHPUNITのモックオブジェクトの動作確認の為のテスト
 *
 * Class ExampleTest
 */
class ExampleTest extends PHPUnit_Framework_TestCase {

    /** @var Example $example */
    private $example;

    /**
     * 全部スタブ化
     * 引数：クラスのみ
     * コンストラクタ：呼ばれる
     * メソッド：全部スタブ化
     */
    public function test_getMock_all() {
        $this->example = $this->getMock(Example::class);
        $result = $this->example->plusA();
        $this->assertNull($result);
    }

    /**
     * 全部スタブ化
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     * メソッド：全部スタブ化
     */
    public function test_createMock_all() {
        $this->example = $this->createMock(Example::class);
        $result = $this->example->plusA();
        $this->assertNull($result);
    }

    /**
     * 一部スタブ化
     * 引数：クラスとメソッド
     * コンストラクタ：呼ばれる
     * メソッド：指定したメソッドだけスタブ化
     */
    public function test_getMock_partial() {
        $this->example = $this->getMock(Example::class, ['getTotal']);
        $result = $this->example->plusB();
        $this->assertEquals(1, $result);
    }

    /**
     * 一部スタブ化
     * 引数：クラスとメソッド
     * コンストラクタ：呼ばれない
     * メソッド：指定したメソッドだけスタブ化
     */
    public function test_createPartialMock_partial() {
        $this->example = $this->createPartialMock(Example::class, ['getTotal']);
        $result = $this->example->plusB();
        $this->assertEquals(1, $result);
    }

    /**
     * 全部スタブ化しない
     * 引数：クラスとNULL
     * コンストラクタ：呼ばれる
     * メソッド：全部スタブ化しない
     */
    public function test_getMock_non() {
        $this->example = $this->getMock(Example::class, NULL);
        $result = $this->example->plusB();
        $this->assertEquals(2, $result);
    }

    /**
     * 全部スタブ化しない
     * 引数：クラスと空の配列
     * コンストラクタ：呼ばれない
     * メソッド：全部スタブ化しない
     */
    public function test_createPartialMock_non() {
        $this->example = $this->createPartialMock(Example::class, []);
        $result = $this->example->plusB();
        $this->assertEquals(1, $result);
    }

    /**
     * 全部スタブ化&返り値指定
     * 引数：クラスと返り値指定した配列
     * コンストラクタ：呼ばれない
     * メソッド：全部スタブ化&返り値設定
     */
    public function test_createConfiguredMock_setStubMethod() {
        $configuration = ['getTotal' => 3];
        $this->example = $this->createConfiguredMock(Example::class, $configuration);
        $result = $this->example->plusB();
        $this->assertNull($result);
    }

    /**
     * 一部スタブ化&返り値指定
     * 引数：クラスとメソッド
     * コンストラクタ：呼ばれない
     * メソッド：一部スタブ化&返り値指定
     */
    public function test_createPartialMock_setStubMethod() {
        $this->example = $this->createPartialMock(Example::class, ['getTotal']);
        $this->example->expects($this->once())->method('getTotal')->willReturn(3);
        $result = $this->example->plusB();
        $this->assertEquals(4, $result);
    }

    /**
     * 一部スタブ化&期待値設定(1 test, 2 assertions)
     * 引数：クラスとメソッド
     * コンストラクタ：呼ばれない
     * メソッド：一部スタブ化
     */
    public function test_createPartialMock_setStubMethod2() {
        $this->example = $this->createPartialMock(Example::class, ['setTotal']);
        $this->example->expects($this->once())->method('setTotal')->with(10);
        $result = $this->example->plusC();
        $this->assertEquals(1, $result);
    }
}
