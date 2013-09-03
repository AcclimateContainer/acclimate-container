<?php

namespace Jeremeamia\Acclimate\Adapter;

use Zend\ServiceManager\Exception\ServiceNotFoundException;

class Zf2ServiceManagerContainerAdapter extends AbstractContainerAdapter
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
        return $this->container->has($name);
    }

    protected function getExpectedContainerFqcn()
    {
        return 'Zend\ServiceManager\ServiceManager';
    }
}
