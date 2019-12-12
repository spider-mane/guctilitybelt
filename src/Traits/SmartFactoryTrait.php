<?php

namespace WebTheory\GuctilityBelt\Traits;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;
use WebTheory\GuctilityBelt\CaseSwap;

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
            $set = false;

            foreach (['set', 'with'] as $prefix) {
                $setter = $this->getSetter($property, $prefix);

                if ($reflection->hasMethod($setter)) {
                    $this->invokeMethod($setter, $instance, $value);
                    $set = true;
                    break;
                }
            }

            if (!$set) {
                throw new InvalidArgumentException("{$property} is not a settable property of {$reflection->name}");
            }

            // if ($reflection->hasMethod($setter = $this->getSetter($property))) {
            //     $this->invokeMethod($reflection->getMethod($setter), $instance, $value);
            // } elseif ($reflection->hasMethod($wither = $this->getSetter($property, 'with'))) {
            //     $this->invokeMethod($reflection->getMethod($wither), $instance, $value);
            // } else {
            //     throw new InvalidArgumentException("{$property} is not a settable property of {$reflection->name}");
            // }
        }

        return $instance;
    }

    /**
     *
     */
    public function getConstructorArgs(ReflectionClass $reflection, array &$args): array
    {
        $construct = [];
        $keys = $this->getKeysAsParameters($args);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();

        foreach ($params as $param) {

            if (in_array($param->name, $keys)) {
                $arg = $this->getArg($param->name);
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
            return $this->getParam($key);
        }, array_keys($args));
    }

    /**
     *
     */
    public function getSetter(string $property, string $prefix = 'set'): string
    {
        return $prefix . CaseSwap::studly($property);
    }

    /**
     *
     */
    public function getArg(string $param): string
    {
        return CaseSwap::snake($param);
    }

    /**
     *
     */
    public function getParam(string $arg): string
    {
        return CaseSwap::camel($arg);
    }
}
