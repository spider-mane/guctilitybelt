<?php

namespace WebTheory\GuctilityBelt\ObjectProxy;

use Psr\Container\ContainerInterface;

trait AllowsExternalModificationTrait
{
    use InternallySwapableFacadeBaseTrait {
        _swap as public _swap;
    }

    /**
     * Clear a resolved facade instance.
     *
     * @param string $name
     * @return void
     */
    public static function _clearResolvedInstance($name)
    {
        unset(static::$resolvedInstances[$name]);
    }

    /**
     * Clear all of the resolved instances.
     *
     * @return void
     */
    public static function _clearResolvedInstances()
    {
        static::$resolvedInstances = [];
    }

    /**
     * {@inheritDoc}
     */
    public static function _setFacadeContainer(ContainerInterface $container)
    {
        static::$container = $container;
    }
}
