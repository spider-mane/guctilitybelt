<?php

namespace WebTheory\GuctilityBelt;

/**
 * Class ContextView
 * @package WebTheory\GuctilityBelt
 */
class ContextView
{
    /**
     * @var array
     */
    protected $items;

    /**
     * @var array
     */
    protected $contexts;

    /**
     * @param array $items
     * @param array $contexts
     */
    public function __construct(array $items, array $contexts)
    {
        $this->items = $items;
        $this->contexts = $contexts;
    }

    /**
     * @param string $context
     * @return mixed
     */
    public function getContext(string $context)
    {
        return $this->contexts[$context];
    }

    /**
     *
     */
    public function getContexts()
    {
        return $this->contexts;
    }

    /**
     * @param string $item
     * @return mixed
     */
    public function getItem(string $item)
    {
        return $this->items[$item];
    }

    /**
     * @param string[] $items
     * @return array
     */
    public function getItems(string ...$items)
    {
        if ($items) {
            $selection = [];

            foreach ($items as $platform) {
                $selection[$platform] = $this->items[$platform];
            }
        }

        return $selection ?? $this->items;
    }

    /**
     * @param string $context
     * @return array
     */
    public function getContextItems(string $context)
    {
        return $this->getItems(...$this->contexts[$context]);
    }
}
