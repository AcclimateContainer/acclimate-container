<?php

namespace Acclimate\Container\Exception;

use Interop\Container\Exception\NotFoundException as InteropNotFoundException;

/**
 * No entry was found in the container.
 */
class NotFoundException extends ContainerException implements InteropNotFoundException
{
    const TEMPLATE = 'There is no entry found in the container for the identifier "{id}".';
}
