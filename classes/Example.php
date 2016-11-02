<?php

class Example {

    private $total = 0;

    public function __construct() {
        $this->total = 1;
    }

    public function plusA() {
        return $this->total += 1;
    }

    public function plusB() {
        $this->total = $this->getTotal();
        return $this->total += 1;
    }

    public function plusC() {
        $this->setTotal(10);
        return $this->total += 1;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }
}
