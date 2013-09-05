<?php

namespace Jeremeamia\Acclimate\Decorator;

use Jeremeamia\Acclimate\ServiceNotFoundException;

class SilentContainerDecorator extends AbstractContainerDecorator
{
    public function get($name)
    {
        try {
            return $this->container->get($name);
        } catch (ServiceNotFoundException $e) {
            return null;
        }
    }
}
