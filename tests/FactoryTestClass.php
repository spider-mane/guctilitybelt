<?php

namespace WebTheory\GuctilityBelt\Tests;

use DateTime;

class FactoryTestClass
{
    protected $value1;
    protected $value2;
    protected $value3;
    protected $value4;
    protected $value5;

    public function __construct($value1, $value2)
    {
        $this->value1 = $value1;
        $this->setValue2($value2);
    }

    public function setValue2($value2)
    {
        $this->value2 = $value2;
    }

    public function setValue3($value3)
    {
        $this->value3 = $value3;
    }

    public function setValue4(DateTime ...$value4)
    {
        $this->value4 = $value4;
    }

    public function withValue5($value5)
    {
        $this->value5 = $value5;
    }

    public function getValue1()
    {
        return $this->value1;
    }

    public function getValue2()
    {
        return $this->value2;
    }

    public function getValue3()
    {
        return $this->value3;
    }

    public function getValue4()
    {
        return $this->value4;
    }

    public function getValue5()
    {
        return $this->value5;
    }
}
