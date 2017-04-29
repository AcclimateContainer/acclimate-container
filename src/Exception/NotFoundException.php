<?php

namespace Acclimate\Container\Exception;

use Psr\Container\NotFoundExceptionInterface;

/**
 * No entry was found in the container
 *
 * @method static NotFoundException fromPrevious($id, \Exception $prev = null)
 */
class NotFoundException extends ContainerException implements NotFoundExceptionInterface
{
    protected static $template = 'There is no entry found in the container for the identifier "{id}".';
}
