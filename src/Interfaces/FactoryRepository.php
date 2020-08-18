<?php

namespace WebTheory\GuctilityBelt\Interfaces;

interface FactoryRepository
{
    /**
     *
     */
    public function getFactoryFor(string $interface): ObjectFactory;
}
