<?php
require_once dirname(__FILE__) . '/../src/Example.php';

/**
 * Phakeの動作確認の為のテスト
 *
 * Class ExamplePhakeTest
 */
class ExamplePhakeTest extends PHPUnit_Framework_TestCase {

    /** @var Example $example */
    private $example;

    /**
     * 全部スタブアウト
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     */
    public function test_createMock_all() {
        $example = \Phake::mock(Example::class);

        $result = $example->plusA();
        $this->assertNull($result);

        $result = $example::staticFunc();
        $this->assertNull($result);

        // privateは直接呼べない
        //$result = $example->plusD();

        // 存在しないメソッドはこける
        //$result = $example->plusNon();
        //$this->assertNull($result);
    }

    /**
     * 全部スタブアウト
     * staticメソッドをスタブ化
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     */
    public function test_createMock_static() {
        $example = \Phake::mock(Example::class);
        \Phake::whenStatic($example)->staticFunc()->thenReturn(2);

        $result = $example::staticFunc();
        $this->assertEquals(2, $result);
    }

    /**
     * 全部スタブアウト
     * privateメソッドを元の処理で呼び出す
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     */
    public function test_createMock_private() {
        $example = \Phake::mock(Example::class);
        // そのまま呼び出す設定
        \Phake::when($example)->plusD()->thenCallParent();

        // 直接は呼び出せないのでmakeVisibleにてプロキシして実行確認可能
        $result = \Phake::makeVisible($example)->plusD();
        $this->assertEquals(1, $result);
    }

    /**
     * 全部スタブアウト
     * privateメソッドをスタブ化
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     */
    public function test_createPartialMock_private() {
        $example = \Phake::mock(Example::class);
        // スタブ化
        \Phake::when($example)->plusD()->thenReturn(5);

        // 直接は呼び出せないのでmakeVisibleにてプロキシして実行確認可能
        $result = \Phake::makeVisible($example)->plusD();
        $this->assertEquals(5, $result);
    }

    /**
     * 全部スタブアウトしない
     *
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれる
     */
    public function test_partialMock_non() {
        $this->example = \Phake::partialMock(Example::class);

        $result = $this->example->plusB();
        $this->assertEquals(2, $result);
    }

    /**
     * 全部スタブアウトしない
     * 指定したメソッドのみスタブ化
     *
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれる
     */
    public function test_partialMock() {
        $this->example = \Phake::partialMock(Example::class);
        \Phake::when($this->example)->getTotal()->thenReturn(2);

        $result = $this->example->plusB();
        $this->assertEquals(3, $result);
    }

    /**
     * 全部スタブアウトしない
     * 期待動作確認(1 test, 2 assertions)
     *
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれる
     */
    public function test_createPartialMock_setStubMethod2() {
        $this->example = \Phake::partialMock(Example::class);

        $result = $this->example->plusC();
        $this->assertEquals(11, $result);
        \Phake::verify($this->example, \Phake::times(1))->setTotal(10);
    }

    public function tearDown() {
        \Phake::resetStaticInfo();
    }
}
