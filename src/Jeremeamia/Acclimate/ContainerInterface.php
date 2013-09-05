<?php

namespace Jeremeamia\Acclimate;

interface ContainerInterface
{
    /**
     * @param string $name
     *
     * @return mixed
     * @throws ServiceNotFoundException If there is no item in the container that matches the provided name
     */
    public function get($name);

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name);
}
