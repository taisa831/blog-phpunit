<?php

class Calculation {

    private $total = 0;

    public function __construct() {
        $this->total = 1;
    }

    public function increment() {
        return $this->total += 1;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }
}
