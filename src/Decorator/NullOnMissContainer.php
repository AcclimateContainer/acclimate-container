<?php

namespace Acclimate\Container\Decorator;

use Acclimate\Api\Container\NotFoundException;

/**
 * A container decorator that changes the default behavior of throwing an exception when an item doesn't exist in the
 * container to instead return NULL
 */
class NullOnMissContainer extends AbstractContainerDecorator
{
    public function get($identifier)
    {
        try {
            return $this->container->get($identifier);
        } catch (NotFoundException $e) {
            return null;
        }
    }
}
