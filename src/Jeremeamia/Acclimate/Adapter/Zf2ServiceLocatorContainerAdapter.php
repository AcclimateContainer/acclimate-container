<?php

namespace Jeremeamia\Acclimate\Adapter;

use Zend\ServiceManager\Exception\ServiceNotFoundException;

class Zf2ServiceLocatorContainerAdapter extends AbstractContainerAdapter
{
    public function get($name)
    {
        try {
            return $this->container->get($name);
        } catch (ServiceNotFoundException $e) {
            $this->handleMissingItem($name, $e);
        }
    }

    public function has($name)
    {
        return $this->container->has($name);
    }
}
