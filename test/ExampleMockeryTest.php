<?php
require_once dirname(__FILE__) . '/../src/Example.php';
//require __DIR__ . '/../vendor/autoload.php';

/**
 * Mockeryの動作確認の為のテスト
 *
 * Class ExampleMockeryTest
 */
class ExampleMockeryTest extends PHPUnit_Framework_TestCase {

    /** @var Example $example */
    private $example;

    /**
     * 全部スタブアウト
     * このまま全てのメソッドは呼びだすとこける
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     */
    public function test_mock_all() {
        $example = Mockery::mock(Example::class);

        // スタブ化してないメソッドはこける
        //$result = $example->plusA();
        //$this->assertNull($result);

        //$result = $example::staticFunc();
        //$this->assertNull($result);

        // privateは直接呼べない
        //$result = $example->plusD();

        // 存在しないメソッドはこける
        //$result = $example->plusNon();
        //$this->assertNull($result);
    }

//    /**
//     * 全部スタブアウト
//     * staticメソッドをスタブ化
//     * require_onceがあると動かない
//     *
//     * 引数：クラスのみ
//     * コンストラクタ：呼ばれない
//     */
//    public function test_mock_static() {
//        $example = Mockery::mock('alias:' . Example::class);
//        $example->shouldReceive('staticFunc')->andReturn(2);
//
//        $result = $example::staticFunc();
//        $this->assertEquals(2, $result);
//    }

    /**
     * 全部スタブアウト
     * 指定したメソッドをスタブ化
     *
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれない
     */
    public function test_mock() {
        $this->example = Mockery::mock('Example');
        $this->example->shouldReceive('plusA')->andReturn('1');

        $result = $this->example->plusA();
        $this->assertEquals(1, $result);
    }

    /**
     * 指定したメソッドのみスタブアウト
     *
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれる
     */
    public function test_partialMock() {
        $this->example = Mockery::mock('Example[getTotal]');

        $result = $this->example->plusA();
        $this->assertEquals(2, $result);
    }

    /**
     * 指定したメソッドのみスタブアウト
     * 振る舞い設定
     *
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれる
     */
    public function test_partialMock_setStubMethod2() {
        $this->example = Mockery::mock('Example[getTotal]');
        $this->example->shouldReceive('getTotal')->andReturn('5');

        $result = $this->example->plusB();
        $this->assertEquals(6, $result);
    }

    /**
     * パッシブパーシャルモック
     * 全部スタブアウトしない
     *
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれない
     */
    public function test_passivePartialMock() {
        $this->example = Mockery::mock('Example')->makePartial();

        $result = $this->example->plusB();
        $this->assertEquals(1, $result);
    }

    /**
     * パッシブパーシャルモック
     * 指定のメソッドのみスタブ化
     *
     * 引数：クラス（コンストラクタに値を渡す場合は引数追加）
     * コンストラクタ：呼ばれない
     */
    public function test_passivePartialMock2() {
        $this->example = Mockery::mock('Example')->makePartial();
        $this->example->shouldReceive('plusB')->andReturn('5');

        $result = $this->example->plusB();
        $this->assertEquals(5, $result);
    }

    public function tearDown() {
        Mockery::close();
    }
}
