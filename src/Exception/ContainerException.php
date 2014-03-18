<?php

namespace Acclimate\Container\Exception;

use Interop\Container\Exception\ContainerException as InteropContainerException;

/**
 * An error occurred when trying to retrieve an entry from the container
 */
class ContainerException extends \RuntimeException implements InteropContainerException
{
    const GENERIC_ERROR = 1;
    const NOT_FOUND_ERROR = 2;

    /**
     * @var string The message template. Allowed variables are {error} and {id}
     */
    protected static $template = 'An {error} occurred when attempting to retrieve the "{id}" entry from the container.';

    /**
     * @var int The error code. These can be used to identify the exception. See the constants of this class
     */
    protected static $errCode = self::GENERIC_ERROR;

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
            '{id}'    => (is_string($id) || is_callable(array($id, '__toString'))) ? $id : '?',
            '{error}' => $prev ? get_class($prev) : 'error',
        ));

        if ($prev) {
            $message .= ' Message: ' . $prev->getMessage() . '.';
        }

        return new static($message, static::$errCode, $prev);
    }
}
