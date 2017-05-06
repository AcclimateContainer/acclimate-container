<?php

namespace Acclimate\Container\Decorator;

use Psr\Container\NotFoundExceptionInterface;

/**
 * A container decorator that changes the default behavior of throwing an exception when an item doesn't exist in the
 * container to instead return NULL
 */
class NullOnMissContainer extends AbstractContainerDecorator
{
    public function get($id)
    {
        try {
            return $this->container->get($id);
        } catch (NotFoundExceptionInterface $e) {
            return null;
        }
    }
}
