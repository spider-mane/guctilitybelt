<?php

use PHPUnit\Framework\TestCase;
use WebTheory\GuctilityBelt\Tests\FactoryTestClass;
use WebTheory\GuctilityBelt\Traits\SmartFactoryTrait;

/**
 * Class SmartFactoryTraitTest
 */
class SmartFactoryTraitTest extends TestCase
{
    public function generateTestInstance()
    {
        return new class
        {
            use SmartFactoryTrait;

            /**
             * @param $args
             * @return FactoryTestClass
             */
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
            'value_one' => 'foo',
            'value_three' => 'bar',
            'value_five' => 45616,
            'value_four' => [new DateTime(), new DateTime(), new DateTime()],
            'value_two' => new DateTime()
        ];

        $instance = $factory->create($args);

        $this->assertEquals($args['value_one'], $instance->getValueOne());
        $this->assertEquals($args['value_two'], $instance->getValueTwo());
        $this->assertEquals($args['value_three'], $instance->getValueThree());
        $this->assertEquals($args['value_four'], $instance->getValueFour());
        $this->assertEquals($args['value_five'], $instance->getValueFive());
    }
}
