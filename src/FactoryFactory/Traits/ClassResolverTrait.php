<?php

namespace WebTheory\GuctilityBelt\Traits;

use WebTheory\GuctilityBelt\CaseSwap;

/**
 * Trait ClassResolverTrait
 * @package WebTheory\GuctilityBelt\Traits
 */
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
     * @param array $namespaces
     * @return ClassResolverTrait
     */
    public function addNamespaces(array $namespaces)
    {
        $this->namespaces = $namespaces + $this->namespaces;

        return $this;
    }

    /**
     * @param string $class
     * @return string
     */
    protected function getClassName(string $class)
    {
        $class = CaseSwap::studly($class);

        if (static::CONVENTION) {
            $class = sprintf(static::CONVENTION, $class);
        }

        return $class;
    }

    /**
     * @param string $namespace
     * @param string $class
     * @return string
     */
    protected function getFqn(string $namespace, string $class)
    {
        return $namespace . '\\' . $this->getClassName($class);
    }

    /**
     * @param string $arg
     * @return bool|string
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
