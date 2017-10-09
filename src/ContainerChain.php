<?php

namespace Acclimate\Container;

use Interop\Container\ContainerInterface;

/**
 * Class ContainerChain
 *
 * A container that delegates to a designated secondary container if the primary container does not contain
 * the requested entry.
 * @package Acclimate\Container
 */
final class ContainerChain implements ContainerInterface
{
    /**
     * @var ContainerInterface
     */
    private $primary;
    /**
     * @var ContainerInterface
     */
    private $secondary;

    /**
     * ContainerChain constructor.
     *
     * @param ContainerInterface $primary
     * @param ContainerInterface $secondary
     */
    public function __construct(ContainerInterface $primary, ContainerInterface $secondary)
    {
        $this->primary = $primary;
        $this->secondary = $secondary;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if ($this->primary->has($id)) {
            return $this->primary->get($id);
        } else {
            return $this->secondary->get($id);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        return $this->primary->has($id) || $this->secondary->has($id);
    }

    /**
     * Create a new container chain from the given containers in order.
     *
     * @param array $containers the containers to chain
     * @return ContainerInterface
     */
    public static function create(array $containers)
    {
        switch (count($containers)) {
            case 0:
                return EmptyContainer::instance();
            case 1:
                return $containers[0];
            default:
                $container = EmptyContainer::instance();
                /** @var ContainerInterface $previous */
                foreach (array_reverse($containers) as $previous) {
                    $container = new self($previous, $container);
                }
                return $container;
        }
    }
}