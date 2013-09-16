<?php

namespace Jeremeamia\Acclimate;

/**
 * A composite container that acts as a normal container, but delegates to one or more internal containers
 */
class CompositeContainer implements ContainerInterface
{
    /**
     * @var array Service containers that are contained within this composite container
     */
    protected $containers;

    /**
     * @param array $containers Service containers to add to this composite container
     */
    public function __construct(array $containers = array())
    {
        foreach ($containers as $container) {
            $this->addContainer($container);
        }
    }

    /**
     * Adds a service container to an internal queue of containers.
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
     * Gets an item from the container by delegating the get call to a FIFO queue of internal containers.
     *
     * @param string $name The name of the item in the container(s)
     *
     * @return mixed
     * @throws ServiceNotFoundException if none of the internal containers have the item
     */
    public function get($name)
    {
        /** @var ContainerInterface $container */
        foreach ($this->containers as $container) {
            if ($container->has($name)) {
                return $container->get($name);
            }
        }

        throw ServiceNotFoundException::fromName($name);
    }

    /**
     * Checks if an item is in at least one of the internal containers
     *
     * @param string $name The name of the item to check for in the internal containers
     *
     * @return bool
     */
    public function has($name)
    {
        /** @var ContainerInterface $container */
        foreach ($this->containers as $container) {
            if ($container->has($name)) {
                return true;
            }
        }

        return false;
    }
}
