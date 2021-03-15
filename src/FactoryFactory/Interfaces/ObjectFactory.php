<?php

namespace WebTheory\GuctilityBelt\Interfaces;

interface ObjectFactory
{
    /**
     *
     */
    public function create(string $class, array $args): object;
}
