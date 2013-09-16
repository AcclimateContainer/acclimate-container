<?php

namespace Jeremeamia\Acclimate;

/**
 * A simple, readonly interface for any service container object
 */
interface ContainerInterface
{
    /**
     * Retrieves an item from the container
     *
     * @param string $name The name of the item in the container
     *
     * @return mixed
     * @throws ServiceNotFoundException If there is no item in the container that matches the provided name
     */
    public function get($name);

    /**
     * Determines if an item is in the container
     *
     * @param string $name The name of the item in the container to look for
     *
     * @return bool
     */
    public function has($name);
}
