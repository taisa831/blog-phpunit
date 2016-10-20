<?php

class PhpTest extends PHPUnit_Framework_TestCase {

    public function setUp() {}

    public function test_empty() {
        $t = '1';
        $this->assertFalse(empty($t));
    }

    public function test_empty2() {
        $t = '0';
        $this->assertTrue(empty($t));
    }
}
