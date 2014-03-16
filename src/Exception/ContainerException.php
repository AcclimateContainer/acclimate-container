<?php

namespace Acclimate\Container\Exception;

use Interop\Container\Exception\ContainerException as InteropContainerException;

/**
 * An error occurred when trying to retrieve an entry from the container
 */
class ContainerException extends \RuntimeException implements InteropContainerException
{
    const TEMPLATE = 'An {error} occurred when attempting to retrieve {id} entry from the container.{message}';

    /**
     * Creates a ContainerException by using the information from the previous exception
     *
     * @param string|mixed $id
     * @param \Exception $prev
     *
     * @return ContainerException
     */
    public static function fromPrevious($id, \Exception $prev = null)
    {
        $message = strtr(static::TEMPLATE, array(
            '{id}'      => (is_string($id) || is_callable(array($id, '__toString'))) ? "the {$id}" : 'an',
            '{error}'   => $prev ? get_class($prev) : 'error',
            '{message}' => $prev ? ' Message: ' . $prev->getMessage() . '.' : '',
        ));

        return new static($message, 0, $prev);
    }
}
