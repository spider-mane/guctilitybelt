<?php

namespace WebTheory\GuctilityBelt\Traits;

trait DynamicCreatorTrait
{
    use SmartFactoryTrait;

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
    abstract public function create(string $name, array $args): object;
}
