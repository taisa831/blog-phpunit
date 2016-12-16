<?php
require_once dirname(__FILE__) . '/../src/Example.php';

/**
 * PHPUNITのモックオブジェクトの動作確認の為のテスト
 *
 * Class ExampleTest
 */
class ExamplePhpUnitMockTest extends PHPUnit_Framework_TestCase {

    /** @var Example $example */
    private $example;

    /**
     * 全メソッド握りつぶす
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     */
    public function test_createMock_all() {
        $this->example = $this->createMock(Example::class);
        $result = $this->example->plusA();
        $this->assertNull($result);

        $result = $this->example->plusB();
        $this->assertNull($result);

        $result = $this->example->plusC();
        $this->assertNull($result);
    }

    /**
     * 全メソッド握りつぶす
     * plusAだけ振る舞い設定
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     */
    public function test_createMock_all_stub() {
        $this->example = $this->createMock(Example::class);
        $this->example->expects($this->once())->method('plusA')->willReturn('A');
        $result = $this->example->plusA();
        $this->assertEquals('A', $result);
    }

    /**
     * 全メソッドスタブ化しない
     *
     * 引数：クラスと空の配列
     * コンストラクタ：呼ばれない
     */
    public function test_createPartialMock_non() {
        $this->example = $this->createPartialMock(Example::class);

        $result = $this->example->plusA();
        $this->assertEquals(1, $result);

        $result = $this->example->plusB();
        $this->assertEquals(2, $result);

        $result = $this->example->plusC();
        $this->assertEquals(11, $result);
    }

    /**
     * 一部スタブ化
     *
     * 引数：クラスとメソッド
     * コンストラクタ：呼ばれない
     */
    public function test_createPartialMock_partial() {
        $this->example = $this->createPartialMock(Example::class, ['getTotal']);

        $result = $this->example->plusA();
        $this->assertEquals(1, $result);

        // getTotalは振る舞いを設定していないためnullとなるがエラーにはならない
        $result = $this->example->plusB();
        $this->assertEquals(1, $result);

        $result = $this->example->plusC();
        $this->assertEquals(11, $result);
    }

    /**
     * 一部スタブ化
     * 振る舞い設定
     *
     * 引数：クラスとメソッド
     * コンストラクタ：呼ばれない
     */
    public function test_createPartialMock_setStub() {
        $this->example = $this->createPartialMock(Example::class, ['getTotal']);
        $this->example->expects($this->once())->method('getTotal')->willReturn(3);

        $result = $this->example->plusA();
        $this->assertEquals(1, $result);

        $result = $this->example->plusB();
        $this->assertEquals(4, $result);

        $result = $this->example->plusC();
        $this->assertEquals(11, $result);
    }

    /**
     * 一部スタブ化
     * 期待値設定(1 test, 4 assertions)
     *
     * 引数：クラスとメソッド
     * コンストラクタ：呼ばれない
     */
    public function test_createPartialMock_setStub2() {
        $this->example = $this->createPartialMock(Example::class, ['setTotal']);
        $this->example->expects($this->once())->method('setTotal')->with(10);

        $result = $this->example->plusA();
        $this->assertEquals(1, $result);

        $result = $this->example->plusA();
        $this->assertEquals(2, $result);

        // setTotalは期待値の設定はあるが振る舞いはないので実行はされない
        $result = $this->example->plusC();
        $this->assertEquals(3, $result);
    }

    /**
     * 全部スタブ化
     * 返り値指定（同時設定）
     *
     * 引数：クラスと返り値指定した配列
     * コンストラクタ：呼ばれない
     */
    public function test_createConfiguredMock_setStubMethod() {
        $configuration = ['getTotal' => 3];
        $this->example = $this->createConfiguredMock(Example::class, $configuration);

        $result = $this->example->plusA();
        $this->assertNull($result);

        $result = $this->example->plusB();
        $this->assertNull($result);

        $result = $this->example->plusC();
        $this->assertNull($result);

        $result = $this->example->getTotal();
        $this->assertEquals(3, $result);
    }
}
