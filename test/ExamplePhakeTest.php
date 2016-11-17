<?php
require_once dirname(__FILE__) . '/../src/Example.php';

/**
 * Phakeの動作確認の為のテスト
 *
 * Class ExamplePhakeTest
 */
class ExamplePhakeTest extends PHPUnit_Framework_TestCase {

    /**
     * 全部スタブ化
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     */
    public function test_mock_all() {
        $example = Phake::mock(Example::class);

        $result = $example->plusA();
        $this->assertNull($result);

        $result = $example->plusB();
        $this->assertNull($result);

        $result = $example->plusC();
        $this->assertNull($result);

        $result = $example::getStaticTotal();
        $this->assertNull($result);
    }

    /**
     * 全部スタブ化しない
     *
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれる
     */
    public function test_partialMock_non() {
        $example = Phake::partialMock(Example::class);

        $result = $example->plusA();
        $this->assertEquals(2, $result);

        $result = $example->plusB();
        $this->assertEquals(3, $result);

        $result = $example->plusC();
        $this->assertEquals(11, $result);
    }

    /**
     * 全部スタブ化しない
     * 指定したメソッドのみスタブ化
     *
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれる
     */
    public function test_partialMock_partial() {
        $example = Phake::partialMock(Example::class);
        Phake::when($example)->getTotal()->thenReturn(3);

        $result = $example->plusA();
        $this->assertEquals(2, $result);

        $result = $example->plusB();
        $this->assertEquals(4, $result);

        $result = $example->plusC();
        $this->assertEquals(11, $result);
    }

    /**
     * 全部スタブ化しない
     * 期待動作確認(1 test, 5 assertions)
     *
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれる
     */
    public function test_partialMock_setStubMethod() {
        $example = Phake::partialMock(Example::class);

        $result = $example->plusA();
        $this->assertEquals(2, $result);

        $result = $example->plusB();
        $this->assertEquals(3, $result);

        $result = $example->plusC();
        $this->assertEquals(11, $result);

        Phake::verify($example, Phake::times(1))->getTotal();
        Phake::verify($example, Phake::times(1))->setTotal(10);
    }

    //
    // static
    //

    /**
     * 全部スタブ化
     * staticメソッドをスタブ化
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     */
    public function test_mock_static() {
        $example = Phake::mock(Example::class);
        Phake::whenStatic($example)->getStaticTotal()->thenReturn(3);

        $result = $example::getStaticTotal();
        $this->assertEquals(3, $result);
    }

    /**
     * 全部スタブ化しない
     * staticメソッドをスタブ化
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     */
    public function test_partialMock_static() {
        $example = Phake::partialMock(Example::class);

        // 直接はNG
        $result = $example::getStaticTotal();
        $this->assertNull($result);

        // 振る舞い設定
        Phake::whenStatic($example)->getStaticTotal()->thenReturn(3);

        $result = $example::getStaticTotal();
        $this->assertEquals(3, $result);
    }

    //
    // private
    //

    /**
     * 全部スタブ化
     * privateメソッドを元の処理を呼ぶ
     * privateメソッドをスタブ化する
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     */
    public function test_mock_private() {
        $example = Phake::mock(Example::class);

        // 元の処理を呼び出す
        Phake::when($example)->plusD()->thenCallParent();
        // 直接は呼び出せないのでmakeVisibleにてプロキシして実行確認可能
        $result = Phake::makeVisible($example)->plusD();
        $this->assertEquals(1, $result);

        // 普通にスタブ化
        Phake::when($example)->plusD()->thenReturn(5);
        // 直接は呼び出せないのでmakeVisibleにてプロキシして実行確認可能
        $result = Phake::makeVisible($example)->plusD();
        $this->assertEquals(5, $result);
    }

    /**
     * 全部スタブ化しない
     * privateメソッドを元の処理を呼ぶ
     * privateメソッドをスタブ化する
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれる
     */
    public function test_partialMock_private2() {
        $example = Phake::partialMock(Example::class);

        // 直接は呼び出せないのでmakeVisibleにてプロキシして実行確認可能
        $result = Phake::makeVisible($example)->plusD();
        $this->assertEquals(2, $result);

        // 普通にスタブ化
        Phake::when($example)->plusD()->thenReturn(5);
        // 直接は呼び出せないのでmakeVisibleにてプロキシして実行確認可能
        $result = Phake::makeVisible($example)->plusD();
        $this->assertEquals(5, $result);
    }

    public function tearDown() {
        Phake::resetStaticInfo();
    }
}
