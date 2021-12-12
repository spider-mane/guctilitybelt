<?php

namespace WebTheory\GuctilityBelt\ObjectProxy;

trait ProphecyMockableFacadeBaseTrait
{
    use InternallySwapableFacadeBaseTrait;

    /**
     * Convert the facade into a Mockery spy.
     *
     * @return \Mockery\MockInterface
     */
    public static function _spy()
    {
        if (!static::_isMock()) {
            $class = static::_getMockableClass();
            $spy = $class ? Mockery::spy($class) : Mockery::spy();

            static::_swap($spy);

            return $spy;
        }
    }

    /**
     * Initiate a partial mock on the facade.
     *
     * @return \Mockery\MockInterface
     */
    public static function _partialMock()
    {
        $name = static::getFacadeAccessor();

        $mock = static::_isMock()
            ? static::$resolvedInstances[$name]
            : static::_createFreshMockInstance();

        return $mock->makePartial();
    }

    /**
     * Initiate a mock expectation on the facade.
     *
     * @return \Mockery\Expectation
     */
    public static function _shouldReceive()
    {
        $name = static::_getFacadeAccessor();

        $mock = static::_isMock()
            ? static::$resolvedInstances[$name]
            : static::_createFreshMockInstance();

        return $mock->shouldReceive(...func_get_args());
    }

    /**
     * Create a fresh mock instance for the given class.
     *
     * @return \Mockery\MockInterface
     */
    protected static function _createFreshMockInstance()
    {
        $mock = static::_createMock();

        static::_swap($mock);
        $mock->shouldAllowMockingProtectedMethods();

        return $mock;
    }

    /**
     * Create a fresh mock instance for the given class.
     *
     * @return \Mockery\MockInterface
     */
    protected static function _createMock()
    {
        $class = static::_getMockableClass();

        return $class ? Mockery::mock($class) : Mockery::mock();
    }

    /**
     * Determines whether a mock is set as the instance of the facade.
     *
     * @return bool
     */
    protected static function _isMock()
    {
        $name = static::_getFacadeAccessor();

        return isset(static::$resolvedInstances[$name]) &&
            static::$resolvedInstances[$name] instanceof LegacyMockInterface;
    }

    /**
     * Get the mockable class for the bound instance.
     *
     * @return string|null
     */
    protected static function _getMockableClass()
    {
        if ($root = static::_getFacadeRoot()) {
            return get_class($root);
        }
    }
}
