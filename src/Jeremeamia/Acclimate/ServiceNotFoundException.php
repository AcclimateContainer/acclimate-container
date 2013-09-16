<?php

namespace Jeremeamia\Acclimate;

/**
 * This exception is thrown when a service cannot be retrieved from a container object
 */
class ServiceNotFoundException extends \RuntimeException
{
    /**
     * This factory method is used to create this exception with a consistent message and more easily set the previous
     * exception without having to change the normal exception constructor interface
     *
     * @param string          $name The name of the service being requested from the container
     * @param null|\Exception $prev The previous exception that was caught, if there was one
     *
     * @return ServiceNotFoundException
     */
    public static function fromName($name, \Exception $prev = null)
    {
        return new self("There is no item in the container for name \"{$name}\".", 0, $prev);
    }
}
