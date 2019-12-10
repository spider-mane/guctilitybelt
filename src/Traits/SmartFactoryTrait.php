<?php

namespace WebTheory\GuctilityBelt\Traits;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;
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
    protected function constructInstance(ReflectionClass $reflection, array &$args): object
    {
        return $reflection->newInstance(...$this->getConstructorArgs($reflection, $args));
    }

    /**
     *
     */
    protected function defineInstance(ReflectionClass $reflection, object $instance, array &$args): object
    {
        foreach ($args as $property => $value) {

            if ($reflection->hasMethod($setter = static::getSetter($property))) {

                $this->invokeMethod($reflection->getMethod($setter), $instance, $value);
            } elseif ($reflection->hasMethod($wither = static::getSetter($property, 'with'))) {
                $this->invokeMethod($reflection->getMethod($wither), $instance, $value);
            } else {
                throw new InvalidArgumentException("{$property} is not a settable property of {$reflection->name}");
            }
        }

        return $instance;
    }

    /**
     *
     */
    public function getConstructorArgs(ReflectionClass $reflection, array &$args)
    {
        $construct = [];
        $keys = $this->getKeysAsParameters($args);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();

        foreach ($params as $param) {

            if (in_array($param->name, $keys)) {
                $arg = static::getArg($param->name);
                $construct[] = $args[$arg];

                unset($args[$arg]);
            } else {
                $construct[] = null;
            }
        }

        return $construct;
    }

    /**
     *
     */
    protected function invokeMethod(ReflectionMethod $method, object $instance, $value)
    {
        $parameter = $method->getParameters()[0];

        if ($parameter->isVariadic() && is_array($value)) {
            $method->invoke($instance, ...$value);
        } else {
            $method->invoke($instance, $value);
        }
    }

    /**
     *
     */
    protected function getKeysAsParameters(array $args): array
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
