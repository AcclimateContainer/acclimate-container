<?php

namespace Acclimate\Container\Exception;

/**
 * There is no adapter class for a provided object
 */
class InvalidAdapterException extends \UnexpectedValueException
{
    /**
     * Creates an InvalidAdapterException using information about the object/value being adapted
     *
     * @param mixed $adaptee
     *
     * @return InvalidAdapterException
     */
    public static function fromAdaptee($adaptee)
    {
        $type = is_object($adaptee) ? get_class($adaptee) . ' objects' : gettype($adaptee) . ' variables';

        return new self("There is no container adapter registered to handle {$type}.");
    }
}
