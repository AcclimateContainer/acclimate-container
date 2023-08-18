<?php

namespace Acclimate\Container;

use Psr\Container\ContainerInterface;
use Acclimate\Container\Exception\NotFoundException;

/**
 * A composite container that acts as a normal container, but delegates method calls to one or more internal containers
 */
class CompositeContainer implements ContainerInterface
{
    /**
     * @var array Containers that are contained within this composite container
     */
    protected $containers = array();

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
     * Finds an entry of the container by delegating the get call to a FIFO queue of internal containers
     *
     * {@inheritDoc}
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
     * Returns true if the at least one of the internal containers can return an entry for the given identifier
     * Returns false otherwise.
     *
     * {@inheritDoc}
     */
    public function has($id): bool
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
