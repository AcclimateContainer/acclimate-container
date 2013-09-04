<?php

namespace Jeremeamia\Acclimate\Adapter;

use Aura\Di\Exception\ServiceNotFound;

class AuraContainerAdapter extends AbstractContainerAdapter
{
    public function get($name)
    {
        try {
            return $this->container->get($name);
        } catch (ServiceNotFound $e) {
            return $this->handleMissingItem($name, $e);
        }
    }

    public function has($name)
    {
        return $this->container->has($name);
    }
}
