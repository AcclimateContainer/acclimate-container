<?php

namespace Acclimate\Container\Exception;

use Interop\Container\Exception\ContainerException as InteropContainerException;

/**
 * An error occurred when trying to retrieve an entry from the container
 */
class ContainerException extends \RuntimeException implements InteropContainerException
{
    /**
     * @var string The message template. Allowed variables are {error} and {id}
     */
    protected static $template = 'An {error} occurred when attempting to retrieve the "{id}" entry from the container.';

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
        $message = strtr(static::$template, array(
            '{id}'    => (is_string($id) || method_exists($id, '__toString')) ? $id : '?',
            '{error}' => $prev ? get_class($prev) : 'error',
        ));

        if ($prev) {
            $message .= ' Message: ' . $prev->getMessage();
        }

        return new static($message, 0, $prev);
    }
}
