<?php


namespace WebTheory\GuctilityBelt\Traits;

use Psr\Container\ContainerInterface;
use RuntimeException;

trait ObjectProxyBaseTrait
{
    /**
     * @var ContainerInterface
     */
    protected static $container;

    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static $resolvedInstances;

    /**
     * Get the root object behind the facade.
     *
     * @return mixed
     */
    public static function _getObjectRoot()
    {
        return static::_resolveInstance(static::_getServiceToProxy());
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws RuntimeException
     */
    protected static function _getServiceToProxy()
    {
        throw new RuntimeException(__CLASS__ . ' does not implement ' . __METHOD__ . ' method.');
    }

    /**
     * Resolve the facade root instance from the container.
     *
     * @param object|string $name
     * @return mixed
     */
    protected static function _resolveInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        if (isset(static::$resolvedInstances[$name])) {
            return static::$resolvedInstances[$name];
        }

        if (static::$container) {
            return static::$resolvedInstances[$name] = static::$container->get($name);
        }
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
     * Get the application instance behind the facade.
     *
     * @return ContainerInterface
     */
    public static function _getProxyContainer()
    {
        return static::$container;
    }

    /**
     * Set the application instance.
     *
     * @param ContainerInterface $container
     * @return void
     */
    public static function _setProxyContainer(ContainerInterface $container)
    {
        static::$container = $container;
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param string $method
     * @param array $args
     * @return mixed
     *
     * @throws RuntimeException
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::_getObjectRoot();

        if (!$instance) {
            throw new RuntimeException('An object has not been defined.');
        }

        return $instance->$method(...$args);
    }
}
