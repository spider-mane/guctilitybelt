<?php

use PHPUnit\Framework\TestCase;
use WebTheory\GuctilityBelt\Tests\FactoryTestClass;
use WebTheory\GuctilityBelt\Traits\SmartFactoryTrait;

class SmartFactoryTraitTest extends TestCase
{
    public function generateTestInstance()
    {
        return new class
        {
            use SmartFactoryTrait;

            public function create($args): FactoryTestClass
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
            'value4' => [new DateTime(), new DateTime(), new DateTime()],
            'value2' => new DateTime()
        ];

        $instance = $factory->create($args);

        $this->assertEquals($args['value1'], $instance->getValue1());
        $this->assertEquals($args['value2'], $instance->getValue2());
        $this->assertEquals($args['value3'], $instance->getValue3());
        $this->assertEquals($args['value4'], $instance->getValue4());
        $this->assertEquals($args['value5'], $instance->getValue5());
    }
}
