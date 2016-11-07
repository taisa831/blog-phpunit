<?php
require_once dirname(__FILE__) . '/../classes/Example.php';

/**
 * Phakeの動作確認の為のテスト
 *
 * Class ExamplePhakeTest
 */
class ExamplePhakeTest extends PHPUnit_Framework_TestCase {

    /** @var Example $example */
    private $example;

    /**
     * 全部スタブ化
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     * メソッド：全部スタブ化
     */
    public function test_createMock_all() {
        $example = \Phake::mock(Example::class);
        $result = $example->plusA();
        $this->assertNull($result);

        //存在しないメソッドはこける
        //$result = $example->plusNon();
        //$this->assertNull($result);
    }

    /**
     * 指定したメソッドのみスタブ化
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれる
     * メソッド：指定したメソッドだけスタブ化
     */
    public function test_partialMock() {
        $this->example = \Phake::partialMock(Example::class);
        \Phake::when($this->example)->getTotal()->thenReturn(2);

        $result = $this->example->plusB();
        $this->assertEquals(3, $result);
    }

    /**
     * 全部スタブ化しない
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれる
     * メソッド：全部スタブ化しない
     */
    public function test_partialMock_non() {
        $this->example = \Phake::partialMock(Example::class);
        $result = $this->example->plusB();
        $this->assertEquals(2, $result);
    }

    /**
     * 一部スタブ化&期待値設定(1 test, 2 assertions)
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれる
     * メソッド：全部スタブ化しない
     */
    public function test_createPartialMock_setStubMethod2() {
        $this->example = \Phake::partialMock(Example::class);
        $result = $this->example->plusC();
        $this->assertEquals(11, $result);
        \Phake::verify($this->example, \Phake::times(1))->setTotal(10);
    }
}
