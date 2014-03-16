<?php

namespace Acclimate\Container;

use Interop\Container\ContainerInterface;
use Acclimate\Container\Exception\NotFoundException;

/**
 * A composite container that acts as a normal container, but delegates to one or more internal containers
 */
class CompositeContainer implements ContainerInterface
{
    /**
     * @var array Containers that are contained within this composite container
     */
    protected $containers;

    /**
     * @param array $containers Containers to add to this composite container
     */
    public function __construct(array $containers = array())
    {
        foreach ($containers as $container) {
            $this->addContainer($container);
        }
    }

    /**
     * Adds a container to an internal queue of containers
     *
     * @param ContainerInterface $container The container to add
     *
     * @return $this
     */
    public function addContainer(ContainerInterface $container)
    {
        $this->containers[] = $container;

        return $this;
    }

    /**
     * Gets an item from the container by delegating the get call to a FIFO queue of internal containers
     *
     * @param string $id The name of the item in the container(s)
     *
     * @return mixed
     * @throws NotFoundException if none of the internal containers contain the entry
     */
    public function get($id)
    {
        /** @var ContainerInterface $container */
        foreach ($this->containers as $container) {
            if ($container->has($id)) {
                return $container->get($id);
            }
        }

        throw NotFoundException::fromPrevious($id);
    }

    /**
     * Checks if an item is in at least one of the internal containers
     *
     * @param string $id The name of the item to check for in the internal containers
     *
     * @return bool
     */
    public function has($id)
    {
        /** @var ContainerInterface $container */
        foreach ($this->containers as $container) {
            if ($container->has($id)) {
                return true;
            }
        }

        return false;
    }
}
