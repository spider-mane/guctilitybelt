<?php

namespace WebTheory\GuctilityBelt\Factory;

use InvalidArgumentException;
use ReflectionClass;
use WebTheory\GuctilityBelt\TxtCase;

trait SmartFactoryTrait
{
    /**
     *
     */
    protected function build(string $class, array $args)
    {
        $reflection = new ReflectionClass($class);
        $instance = $this->constructInstance($reflection, $args);

        return $this->defineInstance($reflection, $instance, $args);
    }

    /**
     *
     */
    protected function constructInstance(ReflectionClass $reflection, array &$args)
    {
        $keys = $this->getKeysAsParameters($args);

        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();

        $construct = [];

        foreach ($params as $param) {

            if (in_array($param->name, $keys)) {
                $arg = static::getArg($param->name);
                $construct[] = $args[$arg];
                unset($args[$arg]);
            } else {
                $construct[] = null;
            }
        }

        return $reflection->newInstance(...$construct);
    }

    /**
     *
     */
    protected function defineInstance(ReflectionClass $reflection, object $instance, array &$args)
    {
        foreach ($args as $property => $value) {

            if ($reflection->hasMethod($setter = static::getSetter($property))) {
                $reflection->getMethod($setter)->invoke($instance, $value);
            } elseif ($reflection->hasMethod($wither = static::getSetter($property, 'with'))) {
                $reflection->getMethod($wither)->invoke($instance, $value);
            } else {
                throw new InvalidArgumentException("{$property} is not a settable property of {$reflection->name}");
            }
        }

        return $instance;
    }

    /**
     *
     */
    protected function getKeysAsParameters(array $args)
    {
        return array_map(function ($key) {
            return static::getParam($key);
        }, array_keys($args));
    }

    /**
     *
     */
    protected static function getSetter(string $property, string $prefix = 'set')
    {
        return $prefix . TxtCase::studly($property);
    }

    /**
     *
     */
    protected static function getArg(string $param)
    {
        return TxtCase::snake($param);
    }

    /**
     *
     */
    protected static function getParam(string $arg)
    {
        return TxtCase::camel($arg);
    }

    /**
     *
     */
    public function __call($name, $args)
    {
        return $this->create(static::getArg($name), $args[0]);
    }

    /**
     *
     */
    public static function __callStatic($name, $args)
    {
        return (new static())->create(static::getArg($name), $args[0]);
    }

    /**
     *
     */
    abstract public function create($name, $args);
}
