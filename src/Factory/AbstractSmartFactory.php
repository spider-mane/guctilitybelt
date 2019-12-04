<?php

namespace WebTheory\GuctilityBelt\Factory;

abstract class AbstractSmartFactory
{
    use SmartFactoryTrait;
    use ClassResolverTrait;

    /**
     *
     */
    protected $namespaces = [];

    /**
     *
     */
    public const NAMESPACES = [];

    /**
     *
     */
    private const CONVENTION = null;

    /**
     *
     */
    public function __construct(string ...$namespaces)
    {
        $this->namespaces = $namespaces + static::NAMESPACES;
    }
}
