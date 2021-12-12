<?php

namespace WebTheory\GuctilityBelt\ObjectProxy;

use Closure;
use Psr\Container\ContainerInterface;

trait UpdatesContainerWithCallbackTrait
{
    protected static Closure $updateContainerCallback;
    protected static ContainerInterface $container;

    protected static function _updateContainer(string $name, object $instance): void
    {
        (static::$updateContainerCallback)(static::$container, $name, $instance);
    }

    public static function _setUpdateContainerCallback(Closure $callback)
    {
        static::$updateContainerCallback = $callback;
    }
}
