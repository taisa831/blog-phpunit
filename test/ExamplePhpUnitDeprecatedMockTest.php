<?php
require_once dirname(__FILE__) . '/../src/Example.php';

/**
 * PHPUNITのモックオブジェクトの動作確認の為のテスト
 *
 * Class ExampleTest
 */
class ExamplePhpUnitDeprecatedMockTest extends PHPUnit_Framework_TestCase {

    /** @var Example $example */
    private $example;

    //
    // getMock系
    //

    /**
     * 全部スタブ化
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれる
     * メソッド：全部スタブ化
     */
    public function test_getMock_all() {
        $this->example = $this->getMock(Example::class);

        $result = $this->example->plusA();
        $this->assertNull($result);

        $result = $this->example->plusB();
        $this->assertNull($result);

        $result = $this->example->plusC();
        $this->assertNull($result);
    }

    /**
     * 全部スタブ化しない
     *
     * 引数：クラスとNULL
     * コンストラクタ：呼ばれる
     * メソッド：全部スタブ化しない
     */
    public function test_getMock_non() {
        $this->example = $this->getMock(Example::class, NULL);

        $result = $this->example->plusA();
        $this->assertEquals(2, $result);

        $result = $this->example->plusB();
        $this->assertEquals(3, $result);

        $result = $this->example->plusC();
        $this->assertEquals(11, $result);
    }

    /**
     * 一部スタブ化
     *
     * 引数：クラスとメソッド
     * コンストラクタ：呼ばれる
     * メソッド：指定したメソッドだけスタブ化
     */
    public function test_getMock_partial() {
        $this->example = $this->getMock(Example::class, ['getTotal']);

        $result = $this->example->plusA();
        $this->assertEquals(2, $result);

        // getTotalは振る舞いを設定していないためnullとなるがエラーにはならない
        $result = $this->example->plusB();
        $this->assertEquals(1, $result);

        $result = $this->example->plusC();
        $this->assertEquals(11, $result);
    }

    //
    // private
    //

    /**
     * privateメソッドはスタブ化されない
     *
     * 引数：クラスのみ
     * コンストラクタ：呼ばれない
     * メソッド：全部スタブ化
     */
    public function test_createMock_all_private() {
        $this->example = $this->createMock(Example::class);

        $result = $this->example->plusA();
        $this->assertNull($result);

        $result = $this->example->plusB();
        $this->assertNull($result);

        $result = $this->example->plusC();
        $this->assertNull($result);

        $reflect = new ReflectionMethod($this->example, 'plusD');
        $reflect->setAccessible(true);
        $result = $reflect->invoke($this->example);
        //$result = $reflect->invokeArgs($this->example, []);
        $this->assertEquals(1, $result);
    }
}
