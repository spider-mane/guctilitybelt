<?php

namespace WebTheory\GuctilityBelt\ObjectProxy;

use Exception;
use Psr\Container\ContainerInterface;
use RuntimeException;

trait FacadeBaseTrait
{
    /**
     * @var ContainerInterface
     */
    protected static ContainerInterface $container;

    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static array $resolvedInstances;

    /**
     * Get the root object behind the facade.
     *
     * @return mixed
     */
    public static function _getFacadeRoot()
    {
        return static::_resolveFacadeInstance(static::_getFacadeAccessor());
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws RuntimeException
     */
    protected static function _getFacadeAccessor()
    {
        throw new RuntimeException(__CLASS__ . ' does not implement ' . __METHOD__ . ' method.');
    }

    /**
     * Resolve the facade root instance from the container.
     *
     * @param object|string $name
     * @return mixed
     */
    protected static function _resolveFacadeInstance($name)
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
     * Get the application instance behind the facade.
     *
     * @return ContainerInterface
     */
    public static function _getFacadeContainer(): ContainerInterface
    {
        return static::$container;
    }

    /**
     * Set the application instance.
     *
     * @param ContainerInterface $container
     * @return void
     *
     * @throws RuntimeException
     */
    public static function _setFacadeContainer(ContainerInterface $container)
    {
        if (!isset(static::$container)) {
            static::$container = $container;
        } else {
            throw new RuntimeException('Container for ' . __CLASS__ . ' has already been set');
        }
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
        $instance = static::_getFacadeRoot();

        if (!$instance) {
            throw new RuntimeException('An instance has not been set for ' . __CLASS__);
        }

        try {
            return $instance->$method(...$args);
        } catch (Exception $methodException) {
            $method = "_$method";

            if (method_exists(static::class, $method)) {
                return ([static::class, $method])(...$args);
            }
        } finally {
            throw $methodException;
        }
    }
}
