<?php

namespace WebTheory\GuctilityBelt;

use DateTime;
use PHPUnit\Framework\TestCase;
use WebTheory\GuctilityBelt\Factory\AbstractSmartFactory;
use WebTheory\GuctilityBelt\Tests\FactoryTestClass;

class AbstractSmartFactoryTest extends TestCase
{
    public function setup(): void
    {
        // include 'FactoryTestClass.php';
    }

    public function generateTestInstance()
    {
        return new class extends AbstractSmartFactory
        {
            public function create($name, $args): FactoryTestClass
            {
                $object = $this->build(FactoryTestClass::class, $args);

                return $object;
            }
        };
    }
    /**
     * Test that true does in fact equal true
     */
    public function testCreatesAndConfiguresSpecifiedClass()
    {
        $factory = $this->generateTestInstance();

        $args = [
            'value1' => 'foo',
            'value3' => 'bar',
            'value5' => 45616,
            'value4' => ['foobar', 202023, new DateTime()],
            'value2' => new DateTime()
        ];

        $instance = $factory->create('test', $args);

        $this->assertEquals($args['value1'], $instance->getValue1());
        $this->assertEquals($args['value2'], $instance->getValue2());
        $this->assertEquals($args['value3'], $instance->getValue3());
        $this->assertEquals($args['value4'], $instance->getValue4());
        $this->assertEquals($args['value5'], $instance->getValue5());
    }
}
