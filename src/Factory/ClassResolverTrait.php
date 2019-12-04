<?php

namespace WebTheory\GuctilityBelt\Factory;

use WebTheory\GuctilityBelt\TxtCase;

trait ClassResolverTrait
{
    /**
     * Get the value of namespace
     *
     * @return mixed
     */
    public function getNamespaces(): array
    {
        return $this->namespaces;
    }

    /**
     * Set the value of namespace
     *
     * @param mixed $namespace
     *
     * @return self
     */
    public function addNamespace(string $namespace)
    {
        $this->namespaces[] = $namespace;

        return $this;
    }

    /**
     *
     */
    public function addNamespaces(array $namespaces)
    {
        $this->namespaces = $namespaces + $this->namespaces;

        return $this;
    }

    /**
     *
     */
    protected function getClassName(string $class)
    {
        $class = TxtCase::studly($class);

        if (static::CONVENTION) {
            $class = sprintf(static::CONVENTION, $class);
        }

        return $class;
    }

    /**
     *
     */
    protected function getFqn(string $namespace, string $class)
    {
        return $namespace . '\\' . $this->getClassName($class);
    }

    /**
     *
     */
    protected function getClass(string $arg)
    {
        foreach ($this->namespaces as $namespace) {

            $class = $this->getFqn($namespace, $arg);

            if (class_exists($class)) {
                return $class;
            }
        }

        return false;
    }
}
