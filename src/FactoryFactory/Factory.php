<?php

namespace WebTheory\GuctilityBelt\Factory;

use WebTheory\GuctilityBelt\Interfaces\FactoryRepository;
use WebTheory\GuctilityBelt\Interfaces\ObjectFactory;
use WebTheory\GuctilityBelt\Traits\ClassResolverTrait;
use WebTheory\GuctilityBelt\Traits\SmartFactoryTrait;

abstract class Factory implements ObjectFactory
{
    use SmartFactoryTrait;
    use ClassResolverTrait;

    /**
     *
     */
    protected $repository;

    /**
     *
     */
    public function __construct(FactoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     */
    protected function getFactory(string $interface)
    {
        return $this->repository->getFactoryFor($this->getClassName($interface));
    }

    /**
     *
     */
    protected function resolveArg()
    {
        //
    }

    /**
     *
     */
    abstract protected function getClassFactories(): array;

    /**
     *
     */
    abstract protected function getNamespaces(): array;
}
