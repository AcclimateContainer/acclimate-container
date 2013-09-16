<?php

namespace Jeremeamia\Acclimate;

/**
 * This exception is thrown when a container object cannot be mapped to an adapter class
 */
class AdapterNotFoundException extends \RuntimeException
{
    /**
     * This factory method is used in order to create this exception with a consistent message
     *
     * @param mixed $container The container object that couldn't be mapped to an adapter
     *
     * @return AdapterNotFoundException
     */
    public static function fromContainer($container)
    {
        $type = is_object($container) ? get_class($container) : gettype($container);

        return new self("There is no container adapter registered to handle containers of the type \"{$type}\".");
    }
}
