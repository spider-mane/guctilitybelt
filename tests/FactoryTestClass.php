<?php

namespace WebTheory\GuctilityBelt\Tests;

use DateTime;

/**
 * Class FactoryTestClass
 * @package WebTheory\GuctilityBelt\Tests
 */
class FactoryTestClass
{
    /**
     * @var
     */
    protected $valueOne;
    /**
     * @var
     */
    protected $valueTwo;
    /**
     * @var
     */
    protected $valueThree;
    /**
     * @var
     */
    protected $valueFour;
    /**
     * @var
     */
    protected $valueFive;

    /**
     * FactoryTestClass constructor.
     * @param $valueOne
     * @param $valueTwo
     */
    public function __construct($valueOne, $valueTwo)
    {
        $this->valueOne = $valueOne;
        $this->setValueTwo($valueTwo);
    }

    /**
     * @param $valueTwo
     */
    public function setValueTwo($valueTwo)
    {
        $this->valueTwo = $valueTwo;
    }

    /**
     * @param $valueThree
     */
    public function setValueThree($valueThree)
    {
        $this->valueThree = $valueThree;
    }

    /**
     * @param DateTime ...$valueFour
     */
    public function setValueFour(DateTime ...$valueFour)
    {
        $this->valueFour = $valueFour;
    }

    /**
     * @param $valueFive
     */
    public function withValueFive($valueFive)
    {
        $this->valueFive = $valueFive;
    }

    public function getValueOne()
    {
        return $this->valueOne;
    }

    public function getValueTwo()
    {
        return $this->valueTwo;
    }

    public function getValueThree()
    {
        return $this->valueThree;
    }

    public function getValueFour()
    {
        return $this->valueFour;
    }

    public function getValueFive()
    {
        return $this->valueFive;
    }
}
