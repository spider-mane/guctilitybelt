<?php

namespace WebTheory\GuctilityBelt\ObjectProxy;

use RuntimeException;
use WebTheory\GuctilityBelt\ObjectProxy\FacadeBaseTrait;

trait InternallySwapableFacadeBaseTrait
{
    use FacadeBaseTrait;

    /**
     * Hotswap the underlying instance behind the facade.
     *
     * @param  mixed  $instance
     * @return void
     */
    protected static function _swap(object $instance)
    {
        static::$resolvedInstances[static::_getFacadeAccessor()] = $instance;

        if (isset(static::$container)) {
            static::_updateContainer(static::_getFacadeAccessor(), $instance);
        }
    }

    protected static function _updateContainer(string $name, object $instance): void
    {
        throw new RuntimeException(__CLASS__ . ' does not implement ' . __METHOD__ . ' method.');
    }
}
