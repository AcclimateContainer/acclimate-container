<?php

namespace Acclimate\Container\Exception;

use Interop\Container\Exception\NotFoundException as InteropNotFoundException;

/**
 * No entry was found in the container
 *
 * @method static NotFoundException fromPrevious($id, \Exception $prev = null)
 */
class NotFoundException extends ContainerException implements InteropNotFoundException
{
    protected static $template = 'There is no entry found in the container for the identifier "{id}".';
    protected static $errCode = self::NOT_FOUND_ERROR;
}
