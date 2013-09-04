<?php

namespace Jeremeamia\Acclimate\Adapter;

use Guzzle\Service\Exception\ServiceNotFoundException;

class GuzzleServiceBuilderContainerAdapter extends AbstractContainerAdapter
{
    public function get($name)
    {
        try {
            return $this->container->get($name);
        } catch (ServiceNotFoundException $e) {
            return $this->handleMissingItem($name, $e);
        }
    }

    public function has($name)
    {
        return isset($this->container[$name]);
    }
}
